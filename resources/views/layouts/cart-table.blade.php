<!-- Product Row -->
{{-- @php
    dd($newCart->books)
@endphp --}}
@foreach ($newCart->books as $id => $book)
<tr>
    <input type="hidden" name="{{'books[' . $id . ']' }}" value="{{ $book['book_name'] }}" />
    <td class="pro-thumbnail"><a href="{{ route('book.detail', $id) }}" target="_blank"><img src="{{ $book['pic'] }}"
                alt="Product"></a></td>
    <td class="pro-title"><a href="{{ route('book.detail', $id) }}" target="_blank">{{ $book['book_name'] }}</a></td>
    <td class="pro-remove"><a><i class="far fa-trash-alt" data-id="{{ $id }}"
                onclick="deleteBookInCart($(this))"></i></a>
    </td>
</tr>
@endforeach
{{-- <tr>
    <td colspan="3" class="actions">
        <div class="row">
            <div class="col-md-6">
                <label class="font-weight-bold">Hình thức lấy sách</label>
                <select class="form-control" aria-placeholder="Lựa chọn hình thức lấy sách" id="delivery"
                    name="delivery">
                    <option value="1" {{ $deliInfo['delivery'] == 1 ? 'selected' : null }}>Tự đến lấy</option>
<option value="2" {{ $deliInfo['delivery'] == 2 ? 'selected' : null }}>Sử dụng đơn vị vận chuyển
</option>
</select>
</div>
<div class="col-md-6">
    <label class="font-weight-bold">Địa chỉ nhận sách</label>
    <input class="form-control" type="text" id="address" name="address"
        placeholder="{{ $deliInfo['delivery'] == 2 ? 'Nhập địa chỉ nhận sách' : 'Không khả dụng' }}"
        value="{{ $deliInfo['address'] }}" {{ $deliInfo['delivery'] == 2 ? '' : 'disabled' }} required>
</div>
</div>
</td>
</tr> --}}
<tr>
    <td colspan="6" class="actions">
        <div class="coupon-block">
            <div class="coupon-text">
                <label for="coupon_code">Tổng số lượng:</label>
                <span class="quantity">{{ $newCart->totalQuantity }}</span>
            </div>
            {{-- <div class="coupon-btn">
                <button type="submit" class="btn btn-outlined">Mượn sách</button>
            </div> --}}
        </div>
    </td>
</tr>
