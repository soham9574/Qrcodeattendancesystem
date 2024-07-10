<!DOCTYPE html>
<html>
<head>
    
<style>


.container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: black; 
}

.login-button {
    padding: 10px 20px;
    font-size: 18px;
    text-align: center;
    text-decoration: none;
    display: block;
    border-radius: 5px;
    margin: 10px auto;
    cursor: pointer;
    width: 200px;
    background-color: #3498db; 
    color: white; 
    border: none; 
}

.employee-button {
    background-color: #e74c3c; 
}
.admin-button {
    background-color: #3498db;
}


.employee-button {
    background-color: #e74c3c; 
}
</style>
</head>
<body>
<div class="container">
    <button class="login-button admin-button" onclick="window.location.href = 'adminlogin.php';">Login as Admin</button>
    <button class="login-button employee-button" onclick="window.location.href = 'emplogin.php';">Login as Employee</button>
    <button class="login-button employee-button" onclick="window.location.href = 'studreg.php';">Register as Student</button>
</div>
</body>
</html>
