    <!-- Required Js -->
    <script src="{{asset('Backend/assets/js/vendor-all.min.js')}}"></script>
    <script src="{{asset('Backend/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('Backend/assets/js/pcoded.min.js')}}"></script>

     <!-- sweet alert Js -->
     <script src="{{asset('Backend/assets/plugins/sweetalert/js/sweetalert.min.js')}}"></script>
    


     <script>
         $(document).ready(function () {
            $("input").on("keypress", function(){
                $input = $(this);
                setTimeout(function(){
                    $input.val($input.val().toUpperCase());
                },50);
            })
         });
     </script>
    @stack('js')
    
 
</body>
</html>
