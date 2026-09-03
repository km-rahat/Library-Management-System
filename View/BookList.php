<?php

// include "../Config/Auth.php";
include "../Model/db.php";

// auth_check("librarian");

$obj = new db();
$conn = $obj->connection();

$books = $obj->GetBooks($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>

    <style>
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body{
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .page-wrapper{
            max-width: 1200px;
            margin: 0 auto;
        }

        .top-bar{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .page-title{
            font-size: 26px;
            font-weight: 600;
            color: #1a3a5c;
        }

        .back-btn{
            background: #ffffff;
            color: #1a3a5c;
            border: 1.5px solid #1a3a5c;
            border-radius: 8px;
            padding: 10px 16px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .back-btn:hover{
            background: #dde3eb;
            transform: translateY(-1px);
        }

        .search-box{
            margin-bottom: 22px;
        }

        #search{
            width: 100%;
            max-width: 420px;
            padding: 12px 15px;
            border: 1px solid #c8d0da;
            border-radius: 10px;
            font-size: 14px;
            background: #ffffff;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        #search:focus{
            border-color: #1a3a5c;
            box-shadow: 0 0 0 3px rgba(26, 58, 92, 0.1);
        }

        .table-container{
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #dde3eb;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        thead{
            background: #1a3a5c;
            color: white;
        }

        th{
            padding: 15px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
        }

        td{
            padding: 14px 15px;
            font-size: 14px;
            color: #333;
            border-top: 1px solid #edf1f5;
        }

        tr:hover td{
            background: #f8fafc;
        }

        .red-row td{
            background: #fff0f0;
            color: #c0392b;
        }

        .red-row:hover td{
            background: #ffe2e2;
        }

        .action-link{
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            margin-right: 8px;
        }

        .edit-link{
            color: #1a3a5c;
        }

        .delete-link{
            color: #c0392b;
        }

        .action-link:hover{
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <div class="top-bar">
        <h1 class="page-title">Book List</h1>

        <a class="back-btn" href="librarian_dashboard.php">
            Back
        </a>
    </div>

    <div class="search-box">
        <input
            type="text"
            id="search"
            placeholder="Search by title, author or ISBN..."
            onkeyup="searchBook()"
        >
    </div>

    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Total Copies</th>
                    <th>Available Copies</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">

                <?php while($row = mysqli_fetch_assoc($books)) { ?>

                    <?php
                        $class = ($row["available_copies"] == 0)
                            ? "red-row"
                            : "";
                    ?>

                    <tr class="<?php echo $class; ?>">

                        <td><?php echo $row["title"]; ?></td>

                        <td><?php echo $row["author"]; ?></td>

                        <td><?php echo $row["genre_name"]; ?></td>

                        <td><?php echo $row["total_copies"]; ?></td>

                        <td><?php echo $row["available_copies"]; ?></td>

                        <td>
                            <a
                                class="action-link edit-link"
                                href="EditBook.php?id=<?php echo $row["id"]; ?>"
                            >
                                Edit
                            </a>

                            |

                            <a
                                class="action-link delete-link"
                                href="../Controller/DeleteBookController.php?id=<?php echo $row["id"]; ?>"
                            >
                                Delete
                            </a>
                        </td>

                    </tr>

                <?php } ?>

            </tbody>
        </table>

    </div>

</div>

<script>

function searchBook()
{
    let search = document.getElementById("search").value;

    if(search == "")
    {
        location.reload();
        return;
    }

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            let books = JSON.parse(this.responseText);

            let output = "";

            books.forEach(book => {

                let className =
                    (book.available_copies == 0)
                    ? "red-row"
                    : "";
                output += `

                
                <tr class="${className}">

                    <td>${book.title}</td>

                    <td>${book.author}</td>

                    <td>${book.genre_name}</td>

                    <td>${book.total_copies}</td>

                    <td>${book.available_copies}</td>

                    <td>

                        <a class="action-link edit-link"
                           href="EditBook.php?id=${book.id}">
                            Edit
                        </a>

                        |

                        <a class="action-link delete-link"
                           href="../Controller/DeleteBookController.php?id=${book.id}">
                            Delete
                        </a>

                    </td>

                </tr>

                `;
            });

            document.getElementById("tableBody").innerHTML = output;
        }
    }

    xhttp.open("GET","../api/books/search.php?q=" + search,true);
    xhttp.send();
}

</script>>

</body>
</html>