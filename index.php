<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Jogo da Mochila</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">

    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-48451062-1']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +      '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script><!-- FIM ANALITYCS-->

    <!-- Chamada Jogo da Mochila -->
    <script type="text/javascript">
        function permitirSoltar(ev) {
            ev.preventDefault();
        }

        function arrastar(ev) {
            ev.dataTransfer.setData("imagem", ev.target.id);
            var dragIcon = document.createElement('img');
            dragIcon.src = "add_icon.png";
            ev.dataTransfer.setDragImage(dragIcon, dragIcon.width / 2, dragIcon.height / 2);
        }

        function soltar(ev) {
            ev.preventDefault();

            // obtem o id da figura que esta sendo arrastada
            var idImagem = ev.dataTransfer.getData("imagem");

            var quantidade = localStorage.getItem(idImagem);
            if (quantidade == null) {
                quantidade = 1;
            }
            else {
                quantidade++;
            }

            save(idImagem, quantidade);
            updateTable();

            //document.getElementById("info").innerHTML += "</br>"+idImagem
        }

        var pesos = new Array();
        pesos["barraca"] = 5;
        pesos["binoculos"] = 0.5;
        pesos["lampiao"] = 0.6;
        pesos["lanterna"] = 0.3;
        pesos["machado"] = 1;
        pesos["canivete"] = 0.2;
        pesos["anzol"] = 0.5;
        pesos["cantil"] = 0.1;
        pesos["mapa"] = 0.1;
        pesos["bussola"] = 0.5;
        pesos["colchonete"] = 0.3;
        pesos["socorros"] = 1.2;
        pesos["violao"] = 0.4;
        pesos["anzol"] = 0.5;

        window.addEventListener("load", updateTable, false);

        function updateTable() {
            $("td#total").text("Total: Kg "); // Apaga o total que está na tela
            var total = 0;

            var tbody = $("tbody").get(0);
            while (tbody.getElementsByTagName("tr").length > 0) {
                tbody.deleteRow(0);
            }
            var row;
            for (var i = 0; i < localStorage.length; i++) {
                row = tbody.insertRow(i);
                cell = row.insertCell(0);
                cell.innerHTML = localStorage.key(i);  // Nome do produto
                cell = row.insertCell(1);
                cell.innerHTML = localStorage.getItem(localStorage.key(i)); // Quantidade
                cell = row.insertCell(2);
                cell.innerHTML = pesos[localStorage.key(i)] // Preço
                cell = row.insertCell(3);
                cell.innerHTML = "<i class=\"fa fa-trash-o fa-2x\" onclick=\"deleteItem('" + localStorage.key(i) + "')\" ></i>";
                   
                total += localStorage.getItem(localStorage.key(i)) * pesos[localStorage.key(i)]; // Calcula o totoal
                $("td#total").text("Total: Kg " + total); // Mostra o total
            }
        }

        function deleteItem(key) {
            if (!confirm("Você tem certeza que deseja excluir esse item?")) return;
            localStorage.removeItem(key);
            updateTable();
        }

        function clearStorage() {
            if (!confirm("Você tem certeza que deseja excluir todos os itens?")) return;
            localStorage.clear();
            updateTable();
        }

        function save(key, value) {
            var key = key;
            var value = value;
            localStorage.setItem(key, value);
            updateTable();
        }
    </script>
	

  </head>

  <body onload="Contador()">	
	
	   <div class="container">        
       <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <a class="navbar-brand" href="http://wagner.ferreiradasilva.tecnologia.ws/mochila/">Jogo da Mochila</a>
          <h4 class="navbar-text"><strong>Arraste os itens para a mochila e veja quanto peso você vai levar na sua aventura</strong></h4> 
          <a class="navbar-brand" href="http://wagner.ferreiradasilva.tecnologia.ws/" target="_blank">Voltar para o site</a>
        </div>
      </div><!--/.navbar-collapse -->
      
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h3>Itens</h3>          
            <img src="images/barraca.png" ondragstart="arrastar(event)" id="barraca" height="100" width="100" />
            <img src="images/binoculos.png" ondragstart="arrastar(event)" id="binoculos" height="100" width="100" /><br>
            <img src="images/lampiao.png" ondragstart="arrastar(event)" id="lampiao" height="100" width="100" />
            <img src="images/lanterna.png" ondragstart="arrastar(event)" id="lanterna" height="100" width="100" /><br>
            <img src="images/machado.png" ondragstart="arrastar(event)" id="machado" height="100" width="100" />
            <img src="images/canivete.png" ondragstart="arrastar(event)" id="canivete" height="100" width="100" /><br>
            <img src="images/anzol.png" ondragstart="arrastar(event)" id="anzol" height="100" width="100" />
          </div>

        <div class="col-md-4">
          <h2>Mochila</h2>
          <img src="images/mochila.png" ondrop="soltar(event)" ondragover="permitirSoltar(event)" style="width: 100%"/>

        Lista da mochila:
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Peso</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <!-- Produtos na mochila -->
            </tbody>
            <tfoot>
                <tr>
                    <td id="total" colspan="4">Total: Kg 00,00</td>
                </tr>
            </tfoot>
        </table>
        <br />
            <button onclick="clearStorage()" style="width: 100%; text-align: center;">Esvaziar mochila</button>
       </div>
      
        <div class="col-md-4">
          <h3>Itens</h3>
          <img src="images/barraca.png" ondragstart="arrastar(event)" id="barraca" height="100" width="100" />        
          <img src="images/cantil.png" ondragstart="arrastar(event)" id="cantil" height="100" width="100" />
          <img src="images/mapa.png" ondragstart="arrastar(event)" id="mapa" height="100" width="100" /><br>
          <img src="images/bussola.png" ondragstart="arrastar(event)" id="bussola" height="100" width="100" />
          <img src="images/colchonete.png" ondragstart="arrastar(event)" id="colchonete" height="100" width="100" /><br>
          <img src="images/socorros.png" ondragstart="arrastar(event)" id="socorros" height="100" width="100" />
          <img src="images/violao.png" ondragstart="arrastar(event)" id="violao" height="100" width="100" />
        </div>
      </div>

      <hr>
     <div id="footer">
      <div class="container">
        <p class="text-muted">Copyright © 2013 - by <a href="http://wagner.ferreiradasilva.tecnologia.ws/" target="_blank">
          Wagner Ferreira </a> <i class="fa fa-facebook-square fa-2x"></i> </p>
      </div>
    </div>

	
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Page Specific Plugins -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>
	
  </body>
</html>
