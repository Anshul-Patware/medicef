<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email required</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        /* background: linear-gradient(to right, #eca73f, #fad0c4); */
        background: #eca73f;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 95%;
        margin: 50px auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    #email {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    input,
    textarea,
    button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 16px;
    }

    button {
        background: #6a67ce;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background: #5a57b7;
    }
</style>


<body>

    <div class="container">
        <div id='email'>
            <div>
                <form action="{{ route('email_save') }}" method="post">
                    @csrf
                    <label for="email">Email : </label>
                    <input type="email" name="email" id="email" placeholder="enter your email" required />
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Get the unique ID from the span element
        // const uniqueid = document.getElementById('unique_id').textContent.trim(); // Use .textContent to get the inner text

        // // Store the value in localStorage
        // localStorage.setItem('uniqueId', uniqueid); // Use uniqueid, not $uniqueid

        // Log the unique ID to verify
        // console.log("Unique ID is:", uniqueid);
    </script>
</body>

</html>
