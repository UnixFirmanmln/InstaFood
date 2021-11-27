<!-- Header -->
<header id="header">
    <a href="#" class="logo">InstaFood</a>

    <form action="hasil_search.php" method="GET" class="form_search">
        <!-- Search -->
        <div class="search">
            <input type="text" name="member" placeholder="silahkan cari"><button name="search" value="search" >Search</button>
        </div>
    </form>
    
    <ul>
        <!-- menu home admin -->
        <li><a href="<?= $_SESSION["level"] == "admin" ? "../admin/index.php" : "index.php" ?>">Home</a></li>
        
        <!-- menu posting -->
        <li><a href="profile.php">Profil</a></li>
        
        <!-- menu logout -->
        <li><a href="../logout.php">Logout</a></li>
    </ul>
    <div class="toggle"></div> <!-- for responsive -->
</header>
<br><br><br><br><br>
