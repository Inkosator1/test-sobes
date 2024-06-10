GET http://localhost:8000/v1/order/index
{
   "count": 3,
   "data": [
   {
      "id": 3,
      "user_id": 1,
      "product": "test",
      "quantity": 2,
      "created_at": "2024-06-10 00:33:12"
   },
   ]
}



POST http://localhost:8000/v1/order/create

{
   "OrderID": 6
}