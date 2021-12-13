<!DOCTYPE html>
<html>
    <head>
        <style>
            html 
            {
                position: relative;
                height: 100%;
            }
            body 
            {
                height: 100%;
                width:100%;
                background-color: #31373D;
            }
            #navbar
            {
                width:100%;
                margin:0px;
                padding:0px;
                background-color: #31373D;
            }
            #navLeft
            {
                margin:0px;
                padding:0px;
                width:50%;
                
            }
            #navRight
            {
                margin:0px;
                padding:0px;
                width:50%;
                text-align:left;
                color: whitesmoke;
            }
        </style>
    </head>
    <body>
        <div id="navbar" class="row" style="width:100%;">
            <div id="navLeft"class="col">
                <form action="buscar.php" method="GET" class="p-0 m-0" style="width:100%; height: auto;">
                    <div class="form-group">
                        <input class="text-center w-100" type="text" name="termino" placeholder="¿Qué necesita?">
                    </div>
                </form>
            </div>
            <div id="navRight" class="col">
                <a style="text-decoration:none; color: whitesmoke" href="./nuevo.php">[NUEVA PUBLICACION]</a>
                <a style="text-decoration:none; color: whitesmoke">[LOGIN]</a>
            </div>
        </div>
    </body>
</html>