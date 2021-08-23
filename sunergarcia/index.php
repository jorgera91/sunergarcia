<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>Blog</title>
    <meta name="description" content="Blog">
    <meta name="keywords" content="Blog, Noticia, Articulo">
    <meta name="author" content="Jorge Rosado">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

  </head>
  <body>
  <header>
      <div class="collapse bg-dark" id="navbarHeader">
          <div class="container">
          </div>
      </div>
      <div class="navbar navbar-dark bg-dark shadow-sm">
          <div class="container d-flex justify-content-between">
              <a href="#" class="navbar-brand d-flex align-items-center">
                  <strong>Blog Test</strong>
              </a>
          </div>
      </div>
  </header>
    <!-- Main -->
    <div class="container">
      <hr>
        <div class="row">
          <!-- Sección de noticias -->
          <div  class="col-12 col-lg-9 mb-5">
            <!-- Noticias -->
            <div id="notices"></div>

            <!-- Navegación páginas -->
              <div class="d-flex justify-content-center">
                <div class="btn-toolbar" >
                  <div id="pages" class="btn-group mr-2" role="group" aria-label="First group">
                  </div>
                </div>
              </div>
            <!-- Fin Navegación páginas -->
          </div>
          <!-- Fin Sección noticias -->
          <!-- Aside -->
        <div id="carousel" class="col-12 col-md-3 carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
              <span  class="text-white sr-only"><i class="bi bi-caret-left-fill"></i>
</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">

              <span class="text-white sr-only"><i class="bi bi-caret-right-fill"></i>
</span>
            </a>
          </div>
          </div>

        </div>
    </div>
    <!-- Fin Main -->
    <!-- Footer -->
  <!-- Footer -->
  <footer class="bg-dark text-center text-white">
      <!-- Grid container -->
      <div class="container p-4">
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
          © 2020 Copyright:
          <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
      </div>
      <!-- Copyright -->
  </footer>
  <!-- Footer -->
    <!-- Fin Footer -->
      
    
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script>

    const getNotices = async(page) => {
      const apiKey = "8a20f77a846f40fa8e9e721f514884d4";
      const resp = await fetch(`https://newsapi.org/v2/top-headlines?country=mx&pageSize=10&page=${page}&apiKey=${apiKey}`);
      const data = await resp.json();
      return data

    }

    const getAuthors = async(id) => {

      const resp = await fetch(`https://randomuser.me/api/?page=${id}&results=10&seed=1`);
      const data = await resp.json();
      console.log(data);
      return data

    }

    const  getAvisos =()=> {
        var dataAjax = "method=getInformationAviso";
        $.ajax({
            data: dataAjax,
            dataType: "json",
            type: "POST",
            url: 'controllers/aviso.php',
            success: function (data) {
                tot =  data.length
                totalCarousel = Math.floor(tot/3);
                if((tot%3) != 0){
                    totalCarousel++;
                }
                console.log(data[0].contenido);
                cont = 0;
                let element = '';
                for (i = 1; i<=totalCarousel;i++){
                     element +=
                        '<div class="carousel-item '+((i == 1) ? 'active' : '')+'">';
                    for (j = 1; j<=3; j++) {
                        if((cont+1) <= tot){
                            element += '<div class="mb-2">' +
                                '<div style="background-image: url(\'https://picsum.photos/id/'+data[cont].id+'/300/200?grayscale\')" class="card card-inverse card-success text-center">' +
                                '<div class="card-block">' +
                                '<blockquote class="card-blockquote">' +
                                '<h3 class="text-primary">'+data[cont].titulo+'</h3>' +
                                '<p class="text-primary">'+data[cont].contenido+'</p>' +
                                '</blockquote>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                            cont++;
                        }

                    }
                        element +=   '</div>';
                }
                $('.carousel-inner').prepend(element);
            console.log(totalCarousel);

            },
            error: function (xhr, textStatus, errorThrown) {
                console.log("Error:", xhr);
            }
        });
    }

    const printNotices = async  (page) =>{

      $('#notices').html('');
      $('#pages').html('');

      data = await getNotices(page);
      totalNotices = data.totalResults;
      totalPages = Math.floor(totalNotices/10);
      if((totalNotices%10) != 0){
        totalPages++;
      }

      notices = data.articles;

      const months = ["Enero", "Febrero", "Marzo","Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

      authors = await getAuthors(page);

      idAuthor = 0;

      notices.map(function(n){
        date = new Date(n.publishedAt);

        let card = '<div class="row mb-5">' +
                '              <div class="col-3">' +
                '                <img class="img-fluid" src="'+n.urlToImage+'" alt=""><br><br>' +
                '                <div class="row">' +
                '                  <div class="col-4">  <img class="img-fluid" src="'+authors.results[idAuthor].picture.thumbnail+'" alt=""></div>' +
                '                  <div class="col-8">   <p class="mb-0 text-center">Autor: '+authors.results[idAuthor].name.first+' '+authors.results[idAuthor].name.last+'</p></div>' +
                '                </div>' +
                '              </div>' +
                '              <div class="col-9">' +
                '                <a href="'+n.url+'"><h3>'+n.title+'</h3></a>' +
                '                <p class="mb-0">'+date.getDate() + " " +  months[date.getMonth()] + " " + date.getFullYear()+'</p>' +
                '                <p>'+n.description+'</p>' +
                '              </div>' +
                '            </div>';

     $('#notices').append(card);
     idAuthor++;

      });

      let pages = '';
      let active = '';
      if(totalPages>0){
        for(i=1; i<=totalPages; i++){

          if(i == 1){
            pages+= '<button type="button" class="btn btn-secondary '+((i == page) ? 'active' : '')+'" onClick="printNotices('+i+')">Inicio</button>';
          }else if(i == totalPages){
            pages+= '<button type="button" class="btn btn-secondary '+((i == page) ? 'active' : '')+'" onClick="printNotices('+i+')">Final</button>';
          }
          else{
            pages+= '<button type="button" class="btn btn-secondary '+((i == page) ? 'active' : '')+'" onClick="printNotices('+i+')">'+i+'</button>';
          }
        }

        $('#pages').append(pages);
      }


    }

    $( document ).ready(function() {
      printNotices(1);
        getAvisos();
    });



  </script>
  </body>
</html>