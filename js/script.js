jQuery(document).ready(function(){
   jQuery("#ocultar").click(function(event){
    event.preventDefault();
    jQuery("#capaefectos").hide("slow");
   });

   jQuery("#mostrar").click(function(event){
    event.preventDefault();
    jQuery("#capaefectos").show(3000);
   });
});

