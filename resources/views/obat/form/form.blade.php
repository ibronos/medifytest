<form method="POST">
    @csrf
    @if($method == 'edit')
    <div class="form-group">
        <label>Id</label>
        <input type="text" class="form-control" name="id" required readonly value="{{$item->id ?? ''}}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required  value="{{$item->nama ?? ''}}">
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tablet') selected @endif>Tablet</option>
            <option @if($selected == 'Sirup') selected @endif>Sirup</option>
        </select>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>