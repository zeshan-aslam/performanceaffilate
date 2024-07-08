const ul = document.querySelector(".example"),
input = document.querySelector(".input_example"),
tagNumb = document.querySelector(".details span");
// const merchant_id = document.querySelector(".merchant_id");
tags = [];


getMerchantBrands();
showTag();
function getMerchantBrands() {
   
    $.ajax({
        type: "GET",
        url: "single_merchant_brands.php",
        data: {},
        async: false,
        success: function (data) {
            console.log(data);
            if (data != "empty") {
                $.each(JSON.parse(data), function (k, val) {
                    console.log(val);
                    tags.push(val);
                });
            } else {
                console.log("empty");
                tags = [];
            }    
        }
    });
}
function showTag() {
    ul.querySelectorAll("li").forEach(li => li.remove());
    tags.slice().reverse().forEach(tag => {
        let liTag = `<li>${tag} <i class="uit uit-multiply" onclick="remove(this, '${tag}')"></i></li>`;
        ul.insertAdjacentHTML("afterbegin", liTag);
    });
}
function createTag() {
    ul.querySelectorAll("li").forEach(li => li.remove());
    tags.slice().reverse().forEach(tag => {

        let liTag = `<li>${tag} <i class="uit uit-multiply" onclick="remove(this, '${tag}')"></i></li>`;
        ul.insertAdjacentHTML("afterbegin", liTag);
    });
   
    $.ajax({
        type: "POST",
        url: "multi_brands_validateTest.php",
        data: {
            UpdatedBrands: tags,
        },
        success: function (data) {
            console.log(data)

            $('.message_box').html(data);
            $('.message_box').addClass("alert alert-success");
            $('.message_box').show();
            setTimeout(function () {
                
                $('.message_box').hide();
            }, 3000);
        }
    });
    
}

function remove(element, tag) {
    let index = tags.indexOf(tag);
    tags = [...tags.slice(0, index), ...tags.slice(index + 1)];
    element.parentElement.remove();
    $.ajax({
        type: "POST",
        url: "multi_brands_validateTest.php",
        data: {
            UpdatedBrands: tags,
        },
        success: function (data) {
            console.log(data)
            $('.message_box').html("Brand Removed Successfully!");
            $('.message_box').addClass("alert alert-success");
            $('.message_box').show();
            setTimeout(function () {
                $('.message_box').hide();
                
            }, 3000);
        }
    });
   
}
function addTag(e){
    if(e.key == "Enter"){
        let latesttag = e.target.value.replace(/\s+/g, ' ');
        tag = latesttag.toLowerCase();
        let validation_flag = validateInput(tag);
          if(tag=='false'|| tag=='true')
          {
            alert("The Words True/False Are Not Allowed!");
          }
          else if(validation_flag==true){

            if(tag.length > 1 && !tags.includes(tag)){
                // if(tags.length < 10){
                   
                // }
                tag.split(',').forEach(tag => {
                    tags.push(tag);
                    createTag();
                });
            }
            e.target.value = "";
          }
      
    }
}
function validateInput(input) {
    var regex = /^[a-zA-Z0-9 ]*$/; // regular expression to allow only alphanumeric and whitespace characters
  
    let msg = "<strong>You can't use special characters!</strong>";
    if (!regex.test(input)) {
        $('.message_box').html(msg);
        $('.message_box').addClass("alert alert-danger");
        $('.message_box').show();
        setTimeout(function () {
            $('.message_box').removeClass("alert alert-danger");
            $('.message_box').hide();
        }, 8000);
      return false;
    }
    
    return true;
  }
  
// function addTag(e) {
//     if (e.key == "Enter") {
//         let tag = e.target.value.replace(/\s+/g, ' ');
//         if (tag.length > 1 && !tags.includes(tag)) {
           
//             tag.split(',').forEach(tag => {
//                 tags.push(tag);
//                 createTag();
//             });
//         }
//         e.target.value = "";
//     }
// }

input.addEventListener("keyup", addTag);

