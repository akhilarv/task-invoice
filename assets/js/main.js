$(document).ready(function () {
    $('#addItem').submit(function (e) {
        var name =  $('#item_name').val();
        var quantity =  $('#quantity').val();
        var price =  $('#unit_price').val();
        var tax =  $('#tax').val();

        if(name =='' || quantity == '' || price == '' || tax == '') {
            alert('Please fill details');
            return false;
        }
        else {
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            data: $(this).serialize(),
            success: function (response) {
                var jsonData = JSON.parse(response);

                if (jsonData.success == "1") {
                    window.location.reload();
                }
                else {
                    alert('Invalid Credentials!');
                }
            }
        });
    }
    });

    $('#add_discount').click(function (e) {
        var subtotal = $('#total_inc_tax').val();
        var discount = $('#discount').val();

        discount = (subtotal * discount) / 100; alert(discount);

        var total = parseInt(subtotal) + parseInt(discount); alert(total);
        $('#total_amount').html(total);


    });

    var button = document.getElementById("generate_invoice");
    button.addEventListener("click", function () {
        var doc = new jsPDF("p", "mm", [300, 300]);
        var makePDF = document.querySelector("#invoice");
        // fromHTML Method
        doc.fromHTML(makePDF);
        doc.save("output.pdf");
    });

});