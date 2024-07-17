<form action="{{ route('reviews.store') }}" method="POST">
    @csrf
    <input type="hidden" name="cake_id" value="{{ $cakeId }}">
    <input type="hidden" name="order_id" value="{{ $orderId }}">

    <div class="form-group">
        <label for="rating">Rating</label>
        <input type="number" id="rating" name="rating" min="1" max="5" value="{{ $review->rating ?? '' }}" placeholder="Did this cake deserve a high five? (1-5)" required class="form-control">
    </div>

    <div class="form-group">
        <label for="review">Review</label>
        <textarea id="review" name="review" rows="4" placeholder="Nailed it or mehhh? Tell us why!" required class="form-control">{{ $review->review ?? '' }}</textarea>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</form>
