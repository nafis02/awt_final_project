import { useState } from "react";

function AddProduct() {
  const [title, setTitle] = useState("");
  const [file, setFile] = useState("");
  const [price, setPrice] = useState("");
  const [discount_price, setDiscount_price] = useState("");
  const [catagory, setCatagory] = useState("");
  const [quantity, setQuantity] = useState("");
  const [description, setDescription] = useState("");

  async function addProduct() {
    console.warn(title, file, price, description);
    const formData = new FormData();
    formData.append("file", file);
    formData.append("title", title);
    formData.append("price", price);
    formData.append("discount_price", discount_price);
    formData.append("catagory", catagory);
    formData.append("quantity", quantity);
    formData.append("description", description);

    let result = await fetch("http://127.0.0.1:8000/api/addproduct", {
      method: "POST",
      body: formData,
    });

    alert("data has been saved")
  }
  return (
    <div className="col-sm-6 offset-sm-4">
      <br />
      <input
        type="text"
        className="form-control"
        onChange={(e) => setTitle(e.target.value)}
        placeholder="Title"
      />
      <br />
      <input
        type="file"
        className="form-control"
        onChange={(e) => setFile(e.target.files[0])}
        placeholder="File"
      />
      <br />
      <input
        type="text"
        className="form-control"
        onChange={(e) => setPrice(e.target.value)}
        placeholder="Price"
      />
      <br />
      
      <input
        type="text"
        className="form-control"
        onChange={(e) => setDiscount_price(e.target.value)}
        placeholder="Discount Price"
      />
      <br />
      
      <input
        type="text"
        className="form-control"
        onChange={(e) => setCatagory(e.target.value)}
        placeholder="Catagory"
      />
      <br />
      
      <input
        type="number"
        className="form-control"
        onChange={(e) => setQuantity(e.target.value)}
        placeholder="Quantity"
      />
      <br />
      <input
        type="text"
        className="form-control"
        onChange={(e) => setDescription(e.target.value)}
        placeholder="Description"
      />
      <br />
      <button onClick={addProduct}>Add Product</button>
    </div>
  );
}

export default AddProduct;
