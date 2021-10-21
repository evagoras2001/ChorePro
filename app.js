const imgDiv = document.querySelector('#alert');
const img = document.querySelector('#photo');
const file = document.querySelector('#file');
const remove=document.querySelector('.omo');
const uploadBtn = document.querySelector('#uploadBtn');




file.addEventListener('change', function(){
    //this refers to fil
    const choosedFile = this.files[0];
    if (choosedFile) {
        const reader = new FileReader();
        var formData = new FormData();
        formData.append("file", choosedFile);
        reader.addEventListener('load', function(){
        var fileName = document.getElementById("file").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
          img.setAttribute('src', reader.result);
        }else{
          imgDiv.style.display = "block";
        }
              });
        reader.readAsDataURL(choosedFile);

    }


});
