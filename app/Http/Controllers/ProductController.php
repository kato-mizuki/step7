<?php

// まずは必要なモジュールを読み込んでいます。今回はProductとCompanyの情報と、リクエストの情報が必要です。
namespace App\Http\Controllers;

use App\Models\Product; // Productモデルを現在のファイルで使用できるようにするための宣言です。
use App\Models\Company; // Companyモデルを現在のファイルで使用できるようにするための宣言です。
use App\Requests\CreateRequest; //バリデーション適用できるようにするのための宣言です。
use Illuminate\Http\Request; // Requestクラスという機能を使えるように宣言します
// Requestクラスはブラウザに表示させるフォームから送信されたデータをコントローラのメソッドで引数として受け取ることができます。

class ProductController extends Controller //コントローラークラスを継承します（コントローラーの機能が使えるようになります）
{
    public function company(){
        $companies = Company::all();
        $validation = new CreateRequest();

        return view('product.index', ['companies' => $companies]);
    }
    
    public function index(Request $request)
    {
        // Productモデルに基づいてクエリビルダを初期化
        $query = Product::query();
        // この行の後にクエリを逐次構築していきます。
        // そして、最終的にそのクエリを実行するためのメソッド（例：get(), first(), paginate() など）を呼び出すことで、データベースに対してクエリを実行します。
    
        // 商品名の検索キーワードがある場合、そのキーワードを含む商品をクエリに追加
        if($search = $request->search){
            $query->where('product_name', 'LIKE', "%{$search}%");
        }
    
        // メーカー名の検索
        if($search = $request->search){
            $query->where('company_name',  'LIKE', "%{$search}%");
        }
    
        
        $products = $query->paginate(10);
    
        // 商品一覧ビューを表示し、取得した商品情報をビューに渡す
        return view('product.index', ['products' => $products]);
        return view('product.create', compact('companies'), [
            'rules' => $validation->rules()
        ]);
    }
    



    public function create()
    {
        // 商品作成画面で会社の情報が必要なので、全ての会社の情報を取得します。
        $companies = Company::all();
        $validation = new CreateRequest();
        return view('products.create', [
            'rules' => $validation->rules(),
        ]);
        // 商品作成画面を表示します。その際に、先ほど取得した全ての会社情報を画面に渡します。
       
    }

    // 送られたデータをデータベースに保存するメソッドです
    public function store(Request $request) // フォームから送られたデータを　$requestに代入して引数として渡している
    {
        // リクエストされた情報を確認して、必要な情報が全て揃っているかチェックします。
        // ->validate()メソッドは送信されたリクエストデータが
        // 特定の条件を満たしていることを確認します。
        $request->validate([
            'product_name' => 'required', //requiredは必須という意味です
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable', //'nullable'はそのフィールドが未入力でもOKという意味です
            'img_path' => 'nullable|image|max:2048',
        ]);
        // '|'はパイプと呼ばれる記号で、バリデーションルールを複数指定するときに使います
        // 'image'はそのフィールドが画像ファイルであることを指定するルールです
        // max:2048'は最大2048KB（2メガバイト）までという意味です
        
        // フォームが一部空欄のまま送信ボタンを押しても、フォームの画面にリダイレクトされ
        // フォームの値が未入力である旨の警告メッセージが表示されます


        // 新しく商品を作ります。そのための情報はリクエストから取得します。
        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);
        //new Product([]) によって新しい「Product」（レコード）を作成しています。
        //new を使うことで新しいインスタンスを作成することができます



        // リクエストに画像が含まれている場合、その画像を保存します。
        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }
        // $request->hasFile('img_path')は、ブラウザにアップロードされたファイルが存在しているかを確認
        // getClientOriginalName()はアップロードしたファイル名を取得するメソッドです。
       // storeAs('products', $filename, 'public')は
       //  アップロードされたファイルを特定の場所に特定の名前で保存するためのメソッドです
       //　今回はstorage/app/publicにproducts" ディレクトリが作られ保存されます
       //'products'：これはファイルを保存するディレクトリ（フォルダ）の名前を示しています。
       // この場合は 'products' という名前のディレクトリにファイルが保存されます。
    //$filename：これは保存するファイルの名前を示しています。
    // getClientOriginalName() メソッドで取得したオリジナルのファイル名がここに入ります。
    // 'public' ファイルのアクセス権限を示しています。'public' は公開設定で、誰でもこのファイルにアクセスすることができるようになります。

        // 作成したデータベースに新しいレコードとして保存します。
        $product->save();

        // 全ての処理が終わったら、商品一覧画面に戻ります。
        return redirect('products');
    }

    public function show(Product $product)
    //(Product $product) 指定されたIDで商品をデータベースから自動的に検索し、その結果を $product に割り当てます。
    {
        // 商品詳細画面を表示します。その際に、商品の詳細情報を画面に渡します。
        return view('product.show', ['product' => $product]);
    //　ビューへproductという変数が使えるように値を渡している
    // ['product' => $product]でビューでproductを使えるようにしている
    // compact('products')と行うことは同じであるためどちらでも良い
    }

    public function edit(Product $product)
    {
        // 商品編集画面で会社の情報が必要なので、全ての会社の情報を取得します。
        $companies = Company::all();
        $product = Product::all();

        return view('products.edit', compact('product', 'companies'), [
            'rules' => $validation->rules()
        ]);
        // 商品編集画面を表示します。その際に、商品の情報と会社の情報を画面に渡します。
       
    }

    public function update(Request $request, Product $product)
    {
        // リクエストされた情報を確認して、必要な情報が全て揃っているかチェックします。
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
        //バリデーションによりフォームに未入力項目があればエラーメッセー発生させる（未入力です　など）

        // 商品の情報を更新します。
        $product->product_name = $request->product_name;
        //productモデルのproduct_nameをフォームから送られたproduct_nameの値に書き換える
        $product->price = $request->price;
        $product->stock = $request->stock;

        // 更新した商品を保存します。
        $product->save();
        // モデルインスタンスである$productに対して行われた変更をデータベースに保存するためのメソッド（機能）です。

        // 全ての処理が終わったら、リダイレクトします。
        return view('product.edit', compact('product'));
        // ビュー画面にメッセージを代入した変数(success)を送ります
    }

    public function destroy(Product $product)
//(Product $product) 指定されたIDで商品をデータベースから自動的に検索し、その結果を $product に割り当てます。
    {
        // 商品を削除します。
        $product->delete();

        // 全ての処理が終わったら、商品一覧画面に戻ります。
        return redirect('/products');
        //URLの/productsを検索します
        //products　/がなくても検索できます
    }
}

