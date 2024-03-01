import Dropzone from 'dropzone';
import './bootstrap';

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone',{
        dictDefaultMessage: 'Sube Tu imagen',
        acceptedFiles: '.png, .jpg,.jpeg, .gif',
        addRemoveLinks: true,
        dictRemoveFile: 'Borrar Archivo',
        maxFiles: 1,
        uploadMultiple: false,

        // agregamos funcion de inicialización para que dropzone muestre la imagen anterior en caso de error de validacion de los campos en el controlador
        init: function(){
                // verificamos el contenido del campo en el formulario
               // var control = document.querySelector("input[name='imagen']");
                //console.log(control);
                
                if(document.querySelector("input[name='imagen']").value.trim()){
                        // para que esto funcione debe existir un name por tanto cereamos un objeto vacio
                        const imagenPublicada = {};
                        // se debe incluir el tamaño como requisito, asi que no importa que sea un dato real
                        imagenPublicada.size = 123;
                        // el nombre de la imagen deberá ser el que teniamos guardado en el formulario
                        imagenPublicada.name = document.querySelector("input[name='imagen']").value;
                        //console.log(document.querySelector("input[name='imagen']").value);
                        
                        // modificar las opciones del dropzone
                        this.options.addedfile.call(this, imagenPublicada);
                        this.options.thumbnail.call(this, imagenPublicada,`/uploads/${imagenPublicada.name}`);

                        imagenPublicada.previewElement.classList.add('dz-succesz', 'dz-complete');

                }
        }
})

dropzone.on("sending", function(file,xhr, formData){
        console.log(formData);
})

dropzone.on("success", function(file, response){
        console.log(response);
        // pasando el nombre de la imagen al controlador de create post
        // el response.imagen  es para extraer del request solo el nombre
        // Ese nombre lo determinamos en el controller al hacer el return en json como se ve en la siguiente linea
        // return response()->json(['imagen' => $nombreImagen]);
        document.querySelector('[name="imagen"]').value = response.imagen
})

dropzone.on("error", function(file, message){
        console.log(message);
})

dropzone.on("removedfile", function(){
        console.log('Archivo Eliminado');
        // reseteamos el valor 
        document.querySelector("input[name='imagen']").value = "";
})
  /*easeeaseasea */

