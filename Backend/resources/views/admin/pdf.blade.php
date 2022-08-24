<! DOCTYPE html>
<html>

<head>
    <title>Order Pdf</title>
</head>

<body>
    <h1>Order Details</h1>

   Customer Name: <h3>{{$order->name}}</h3>
    
   Customer email:<h3>{{$order->email}}</h3>
    
   Customer Address:<h3>{{$order->address}}</h3>
    
   Customer Phone:<h3>{{$order->phone}}</h3>

   
   Customer Id:<h3>{{$order->user_id}}</h3>

   
   Product Name:<h3>{{$order->product_title}}</h3>

   Product Quantity:<h3>{{$order->quantity}}</h3>

   Product Price:<h3>{{$order->price}}</h3>

   Payment Status:<h3>{{$order->payment_status}}</h3>

   Product Id:<h3>{{$order->product_id}}</h3>




</body>
</html>
