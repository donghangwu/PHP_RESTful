<?php
class Post{
    
    private $pdo;//pdo db connection
    private $table='posts';

    //post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db)
    {
        $this->pdo=$db;
    }

    //Get post Route
    public function getPosts()
    {
        $query='SELECT 
        categories.name as category_name,
        posts.id,
        posts.category_id,
        posts.body,
        posts.title,
        posts.author,
        posts.created_at
        FROM '.$this->table.'
        LEFT JOIN
            categories ON posts.category_id = categories.id
        ORDER BY
            posts.created_at DESC
        ';

        //prepare statement;
        $statement=$this->pdo->prepare($query);
        
        //Excute query
        $statement->execute();
        return $statement;
    }
    public function single_post()
    {
        $query='SELECT 
            categories.name as category_name,
            posts.id,
            posts.category_id,
            posts.body,
            posts.title,
            posts.author,
            posts.created_at
        FROM '.$this->table.'
        LEFT JOIN
            categories ON posts.category_id = categories.id
        WHERE posts.id=?
        LIMIT 0,1
        ';// id=? is a place holder

        //prepare statement;
        $statement=$this->pdo->prepare($query);
        $statement->bindParam(1,$this->id);
        //Excute query
        $statement->execute();

        return $statement;
    }

    public function create_post()
    {
       //create query statement
       $query = 'INSERT INTO '
                 .$this->table.'
                 SET
                    title=:title,
                    body = :body,
                    author = :author,
                    category_id = :category_id';
        $statement = $this->pdo->prepare($query);

        // Clean data
        $this->title=htmlspecialchars(strip_tags(($this->title)));
        $this->body=htmlspecialchars(strip_tags(($this->body)));
        $this->author=htmlspecialchars(strip_tags(($this->author)));
        $this->category_id=htmlspecialchars(strip_tags(($this->category_id)));

        //bind the data
        $statement->bindParam(':title',$this->title);
        $statement->bindParam(':body',$this->body);
        $statement->bindParam(':author',$this->author);
        $statement->bindParam(':category_id',$this->category_id);

        // Excute query
        // Create post
        if($statement->execute())
        {
            return true;
        }
        else{
            printf("error: %s \n",$statement->error);
            return false;
        }
    }


    public function update_post()
    {
       //update query statement
       $query = 'UPDATE '
                 .$this->table.'
                 SET
                    title=:title,
                    body = :body,
                    author = :author,
                    category_id = :category_id
                 WHERE id = :id';
        $statement = $this->pdo->prepare($query);

        // Clean data
        $this->title=htmlspecialchars(strip_tags(($this->title)));
        $this->body=htmlspecialchars(strip_tags(($this->body)));
        $this->author=htmlspecialchars(strip_tags(($this->author)));
        $this->category_id=htmlspecialchars(strip_tags(($this->category_id)));
        $this->id=htmlspecialchars(strip_tags(($this->id)));

        //bind the data
        $statement->bindParam(':title',$this->title);
        $statement->bindParam(':body',$this->body);
        $statement->bindParam(':author',$this->author);
        $statement->bindParam(':category_id',$this->category_id);
        $statement->bindParam(':id',$this->id);

        // Excute query
        // Create post
        if($statement->execute())
        {
            return true;
        }
        else{
            printf("error: %s \n",$statement->error);
            return false;
        }
    }

    // Delete Post
    public function delete_post()
    {
        // Create query
        $query = 'DELETE FROM '.$this->table 
                .' WHERE id = :id';
        $statement = $this->pdo->prepare($query);  
        $this->id=htmlspecialchars(strip_tags(($this->id)));
  
        $statement->bindParam(':id',$this->id);

        if($statement->execute())
        {
            return true;
        }
        else{
            printf("error: %s \n",$statement->error);
            return false;
        }

    }

    
}