"use strict";


function confirmDelete(){
    if(confirm("Are you sure you want to delete your account?This action cannot be undone.")){
        window.location.href="delete.php";
    }
}
