<?php 
class BookController extends BaseController {
    private $bookModel;
    public function __construct()
    {
        $_POST = json_decode(file_get_contents("php://input"),true);
        $this->loadModel('BookModel');
        $this->bookModel = new BookModel;
    }
    public function index(){
        
    }
    public function getAll(){
        $books = $this->bookModel->getAllBook(BookModel::TABLE);
        echo json_encode($books);
    }
    public function getbycategory(){
        if(isset($_GET['category'])){
            $category = $_GET['category'];
            $books = $this->bookModel->getByCategoryBook(BookModel::TABLE, $category);
            echo json_encode($books);
        }
    }
    public function getbyIndex(){
        if(isset($_GET['id_book'])){
            $id_book = $_GET['id_book'];
            $book = $this->bookModel->getBookByIndex(BookModel::TABLE ,$id_book);
            echo json_encode($book);
        }
    } 
    public function searchMachine(){
        if(isset($_POST['searchText'])){
            $text = $_POST['searchText'];
            $results_book = $this->bookModel->fetchByMachineSearch($text);
            echo json_encode(
                array(
                    'status' => '200',
                    'payload' => $results_book
                )
            );
        }
    }
    public function addToCart(){
        
      
    }
  
    public function editBook(){
        if(isset($_POST['name']) && isset($_POST['id_book'])){
            $id_book = $_POST['id_book'];
            $name  = $_POST['name'];
            $bookLine  = $_POST['bookLine'];
            $quantity  = $_POST['quantity'];
            $ordered  = $_POST['ordered'];
            $price  = $_POST['price'];
            $publisher  = $_POST['publisher'];
            $desciption = $_POST['description'];
            $views  = $_POST['views'];
            $author  = $_POST['author'];
            $image  = $_POST['image'];
            $flag = $this->bookModel->editBookById(BookModel::TABLE, $id_book , $name, $bookLine ,$quantity, $ordered, $price, $author, $publisher, $views, $desciption, $image);
            if($flag){
                echo json_encode(
                    array(
                        'status' => 200,
                        'payload' => $flag,
                    )
                );
            }

        }   
    }
    public function randomBook(){
        $name = ['The Paying Guests','Jane Eyre','Watership Down','Lord of the Flies','The Vegetarian','The Adventures of Huckleberry Finn','Anne of Green Gables','Adventures of Sherlock Holmes','The Color Purple','All Quiet on the Western Front','Frankenstein'];
        $author = ['Chimamanda Ngozi Adichie','Nevil Shute','Han Kang','Mark Twain','Lucy Maud Montgomery','Arthur Conan Doyle','George Orwell'];
        $bookline = ['Cartoon','Hornor','Novel','Fiction','Love stories', 'Biography'];
        $publisher = ['Penguin Random House','Hachette Livre','HarperCollins','Macmillan Publishers','Simon & Schuster','McGraw-Hill Education'];
        $desciption = [
            'Want to instantly capture readers? No matter who you are or what genre your book falls into—nothing beats getting engrossed in a book description that leaves a reader wanting more. Short and long book descriptions both serve a purpose—to make you and your book look good. Before you start writing, here are a few things you need to know.',
            'There are several things to consider in order to help your book achieve its greatest potential discoverability. ',
            'Readers, librarians, and retailers cant purchase a book they cant find, and your book metadata is responsible for whether or not your book pops up when they type in search terms relevant to your book. ',
            'Whether reading the short or long description, both need to be full of what readers want: intrigue. It’s up to you to get readers interested in what you have to say,',
            'The short description is exactly that—short and sweet. Consider it a blurb, elevator pitch, or hook. It tells enough about your book to keep readers interested, ',
            'Publishers use this short book description to showcase and sell. It appears in publishing catalogs, trade show copy,',
            '. Its your books calling card for the world to see. Informative, engaging and thought-provoking. That’s the reaction you want each time someone reads it. ',
            'Although the long and short book descriptions stand alone, they play off each other to provide rich content for your potential buyers. ',
            'Strong book metadata is necessary to your books success. How to write a good book description is just one piece.',
            'Look at other long and short descriptions to determine whether or not you find them engaging and get tips from the ones you do.',
        ];
        $image = [
            'https://www.penguin.co.uk/content/dam/prh/books/109/1093443/9780091948993.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/91salBA6P4L.jpg',
            'https://cdn.britannica.com/21/182021-050-666DB6B1/book-cover-To-Kill-a-Mockingbird-many-1961.jpg',
            'https://i1.wp.com/bestlifeonline.com/wp-content/uploads/2020/10/Harry-Potter-and-the-Chamber-of-Secrets-book-cover.jpg?resize=798%2C1200&ssl=1',
            'http://www.teleread.com/wp-content/uploads/2015/08/moby-dick.jpg',
            'https://images-na.ssl-images-amazon.com/images/I/51jxyYL8lQL._SX328_BO1,204,203,200_.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTnmnVc940Uwk6lP81Iy7T_oe8UVE6vs2apTQ&usqp=CAU',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGT-rbb98n4n4HXPhkIEe3rcyoj-Dx_ab8rA&usqp=CAU',
            'https://i.pinimg.com/originals/5a/9b/b0/5a9bb0b9ada80d6d4647ace23ba11e65.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQsWvuWAWhkZMMl6-1OvvpE4o9vxXrgW7IaQ&usqp=CAU',
            'https://i.pinimg.com/236x/3e/20/6b/3e206b5824c721fec49a9453b4336f09--christian-grey-james-darcy.jpg',
            'http://www.scrolldroll.com/wp-content/uploads/2021/07/the-hobbit-best-selling-books-of-all-time.jpg',
            'https://imagesvc.meredithcorp.io/v3/mm/image?url=https%3A%2F%2Fstatic.onecms.io%2Fwp-content%2Fuploads%2Fsites%2F6%2F2018%2F03%2F91xl8vzglyl-2000.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTFguopTfPyOLGfPUj5Z6rRb4sIPBkQTch0ow&usqp=CAU',
            'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1594925043i/53138081.jpg'
        ];
        $data = [];
        //rand(int $min, int $max): int
        for($i = 50 ; $i < 70 ; $i++){
            $line = $bookline[rand(0,5)];
            $id_book = '';
            switch($line){
                case 'Cartoon': {
                    $id_book = 'CR_'. ($i + 10);
                    break;
                }
                case 'Hornor': {
                    $id_book = 'HN_'. ($i + 10);
                    break;
                }
                case 'Novel' : {
                    $id_book = 'NV_'. ($i + 10);
                    break;
                }
                case 'Biography' : {
                    $id_book = 'BI_'. ($i + 10);
                    break;
                }
                case 'Fiction' : {
                    $id_book = 'FA_'. ($i + 10);
                    break;
                }
                case 'Love stories': {
                    $id_book = 'LS_'. ($i + 10);
                    break;
                }
            };
            $result = '(\''. $id_book .'\',' .'\''.  $name[rand(0, 10)]. '\','. '\''. $line .'\','. ''. rand(300,500).',' . ''. rand(0, 300).','. '' .rand(20,100). ','. '\''. $author[rand(0,6)].'\','.'\''.$publisher[rand(0,5)] .'\','. '' . rand(0,1000) . ','.'\''. $desciption[rand(0,9)]. '\''. ',\'' .$image[rand(0,14)] . '\''.'),';
            echo "<br/>";
            echo $result;
        }
    }
    public function fetchConditionsCategories(){
        if(isset($_POST['views']) && isset($_POST['author']) && isset($_POST['price']) && isset($_POST['publisher'])){
            $genres = $_POST['genres'];
            $views = $_POST['views'];
            $author = $_POST['author'];
            $price = $_POST['price'];
            $publisher = $_POST['publisher'] ;
            if($_POST['author'] == "all_author"){
                $author = '';
            }else{
                $author = " AND author = '" .$author .'\'';
            }
            if($_POST['publisher'] === "all_pub"){
                $publisher = '';
            }else{
                $publisher = " AND publisher = '" .$publisher. '\'';
            }
            $conditions = "bookLine = '" . $genres  . "' AND price > " . $price . " AND views >= " .$views .$publisher .$author ;
            $sql = 'SELECT * FROM `books` WHERE ' .$conditions;
            $books = $this->bookModel->fetchByManyConditions( $sql);
            echo json_encode(
                array(
                    'status' => 200,
                    'payload' => $books
                 )
                );
        }else{
            $sql = "SELECT * FROM `books` WHERE books.bookLine = '" .$_POST['genres']  . "'";
            $books = $this->bookModel->fetchByManyConditions($sql);
            echo json_encode(
                array(
                    'status' => 200,
                    'payload' => $books
                )
                );
        }
        
    }

    
}
?>