<div class="modal-body" id="unique_id_performance_view">
    <div class="row">
        <div class="col-md-12">
            <h1>Performance Reviews</h1>
            <ul>
                @foreach ($performanceReviews as $review)
                    <li>{{ $review->employee->name }} - Review Date: {{ $review->review_date }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
