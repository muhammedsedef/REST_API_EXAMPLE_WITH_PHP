
const add_product_button = document.getElementById('add-product');
add_product_button.addEventListener("click", function(event) {
    event.preventDefault()
    const title = $('#title').val();
    const description = $('#description').val();
    const link = $('#link').val();
    
    var request_body = 
    {
        "name" : title,
        "description" : description,
        "image_url" : link
    }
    request_body = JSON.stringify(request_body);
    console.log(request_body)
    $.post('http://localhost:8080/test_api/api/product/create.php',request_body, function(response) {
        const response_object = JSON.parse(response);
        console.log(response_object);
        if(response_object.status != 200) console.log(response_object.message)
        else console.log(response_object.message);
    })

})