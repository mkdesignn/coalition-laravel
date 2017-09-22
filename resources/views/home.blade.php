<!DOCTYPE HTML>
<html style='background-color:#E5E6E6'>
<head>
    <title>colation</title>
    <meta charset='UTF-8'>
{{--    {!! Html::style('css/style.css')!!}--}}
    {!! Html::style('css/bootstrap.min.css')!!}
    {!! Html::style('css/font.css')!!}
    {!! Html::style('css/font-awesome.css')!!}
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div class="container">
        <br>
        <br>
        <br>
        <p>Please enter your product data in below form .</p>
        <div class="form_wrapper" style="overflow:auto;">
            {!! Form::open(["url"=>action("HomeController@postStore")]) !!}
            <div class="col-md-4 right">
                <div class="form-group">
                    <label class="control-label">Product Name</label>
                    <div class="input-group">
                        {!! Form::text("product_name", null, ["class"=>"form-control"]) !!}
                        <span class="input-group-addon">
                                    <i class="icon-user"></i>
                                </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 right">
                <div class="form-group">
                    <label class="control-label">Quantity </label>
                    <div class="input-group">
                        {!! Form::text("Quantity", null, ["class"=>"form-control"]) !!}
                        <span class="input-group-addon">
                                    <i class="icon-user"></i>
                                </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 right">
                <div class="form-group">
                    <label class="control-label">Price per item</label>
                    <div class="input-group">
                        {!! Form::text("price_per_item", null, ["class"=>"form-control"]) !!}
                        <span class="input-group-addon">
                                    <i class="icon-user"></i>
                                </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-primary" value="Save Product"/>
            </div>
            {!! Form::close() !!}
        </div>
        <br>
        <br>

        <div class="grid_wrapper">

            <table class="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Product_name</th>
                    <th>Quantity</th>
                    <th>price per item</th>
                    <th>Datetime submited</th>
                    <th>Total value number</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>

    {!! Html::script('js/jquery-2.1.4.min.js')!!}
    {!! Html::script('js/bootstrap.min.js')!!}
    <script>

        jQuery(function($){
            $("form").on("submit", function(e){
                e.preventDefault();
                var url = $(this).attr("action"),
                        form_data = new FormData($(this)[0]);

                $.ajax({
                    url: url,
                    type: "post",
                    data: form_data,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        var table = jQuery("table tbody");
                        table.find("tr").remove();
                        jQuery.each(JSON.parse(response), function(key, value){
                            console.log(value);
                            var tr = "<tr>",
                                    id = "<td>"+key+"</td>",
                                    product_name = "<td> "+value.product_name+" </td>",
                                    Quantity = "<td> "+value.Quantity+" </td>",
                                    price_per_item = "<td> "+value.price_per_item+" </td>",
                                    Datetime = "<td> "+value.Datetime+" </td>",
                                    total_value = "<td> "+value.Quantity * value.price_per_item +" </td>";

                            table.append("<tr>"+id+product_name+Quantity+price_per_item+Datetime+total_value+"</tr>");
                        })
                    }
                })
            })



            // load data on the screen on first time
            $.ajax({
                url: "{{action("HomeController@getIndex")}}",
                type: "get",
                success: function(response){
                    var table = jQuery("table tbody");
                    table.find("tr").remove();
                    jQuery.each(response, function(key, value){
                        var tr = "<tr>",
                                id = "<td>"+key+"</td>",
                                product_name = "<td> "+value.product_name+" </td>",
                                Quantity = "<td> "+value.Quantity+" </td>",
                                price_per_item = "<td> "+value.price_per_item+" </td>",
                                Datetime = "<td> "+value.Datetime+" </td>",
                                total_value = "<td> "+value.Quantity * value.price_per_item +" </td>";

                        table.append("<tr>"+id+product_name+Quantity+price_per_item+Datetime+total_value+"</tr>");

                    })
                }
            })

        })
    </script>
</body>
</html>



