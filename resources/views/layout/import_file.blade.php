<form method="POST" action="{{route('file')}}" enctype="multipart/form-data">
  @csrf()
  <input type="file" name="file">
  <input type="submit" name="submit" value="submit">
</form>
