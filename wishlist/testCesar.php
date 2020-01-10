
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="photo">
            <input type="submit">
        </form>
        <img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/2d04bb6b-4e46-4236-bfbb-aeba05f80f79/ddnrbko-aa1d16ab-9cbd-44eb-9854-54112fb8acca.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcLzJkMDRiYjZiLTRlNDYtNDIzNi1iZmJiLWFlYmEwNWY4MGY3OVwvZGRucmJrby1hYTFkMTZhYi05Y2JkLTQ0ZWItOTg1NC01NDExMmZiOGFjY2EucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.bsdgZCE9Oie3qggdboNi0IqSCvVgUENeGVONUvC3RQE">
    </body>
</html>

<?php
use wishlist\modele\Item;
$item = Item::where('liste_id','=',$this->liste->no);
var_dump($item);