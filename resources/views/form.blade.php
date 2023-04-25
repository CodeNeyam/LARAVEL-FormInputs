<!DOCTYPE html>
<html>
<head>
    <title>Laravel Form</title>
</head>
<body>
    <form action="/form-data" method="post" enctype="multipart/form-data" novalidate>

        @csrf
   @foreach ($errors->all() as $error)
      <div>{{ $error }}</div>
  @endforeach
        <label>Text:</label>
        <input type="text" name="text" required>
        <br>
        <br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <br>
        <label>Number:</label>
        <input type="number" name="number" required>
        <br>
        <br>
        <label>Select:</label>
        <select name="select" required>
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
        <br>
        <br>
        <label>Image:</label>
        <input type="file" name="img" accept="image/*" required>
        <br>
        <br>
        <label>File:</label>
        <input type="file" name="file" required>
        <br>
        <br>
        <label>URL:</label>
        <input type="url" name="url" required>
        <br>
        <br>
        <label>Checkboxes:</label>
        <br>
        <input type="checkbox" name="checkboxes[]" value="checkbox1"> Checkbox 1
        <br>
        <input type="checkbox" name="checkboxes[]" value="checkbox2"> Checkbox 2
        <br>
        <input type="checkbox" name="checkboxes[]" value="checkbox3"> Checkbox 3
        <br>
        <br>
        <label>Radio buttons:</label>
        <br>
        <input type="radio" name="radio" value="radio1" required> Radio 1
        <br>
        <input type="radio" name="radio" value="radio2" required> Radio 2
        <br>
        <input type="radio" name="radio" value="radio3" required> Radio 3
        <br>
        <br>
        <label>Date:</label>
        <input type="date" name="date" required>
        <br>
        <br>
        <button type="submit">Submit</button> 
    </form>
    @if (session('success'))
    <div>
        <p>{{ session('success') }}</p>
        @if(session('submit_case'))
            <a href="{{ url('/form-data/' . session('formData') . '/download') }}">Download Data as XLSX</a>
            <br>
            <br>
	 <a href="{{ url('/form-data/download-all') }}">Download All Data as XLSX</a>
        @endif
    </div>
@endif
    <br>
    <br>
    <form action="/form-data/import" method="post" enctype="multipart/form-data">
        @csrf
        <label for="file">XLSX:</label>
        <input type="file" name="file" accept=".xlsx" required>
        <br>
        <br>
        <button type="submit">Import</button>
    </form>


</body>
</html>

