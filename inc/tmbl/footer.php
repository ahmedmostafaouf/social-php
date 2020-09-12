
		    
            <script type="text/javascript" src="themes/js/jquery-3.1.0.min.js"></script>
            <script type="text/javascript" src="themes/js/bootstrap.min.js"></script>
            <script>  
       $(document).ready(function(e){
        $("#Chat").on('submit', function(e){
         e.preventDefault();
         $.ajax({
              type: 'POST',
              url :'send.php',
              data : new FormData(this),
              contentType :false,
              cache :false,
              processData :false,
              success:function(data){
                  $('#Success').html(data);
              }
     });
     
     $('#msg').val("");

 });
       });
       </script>
        <!-- cdnjs -->
       
    </body>
</html>