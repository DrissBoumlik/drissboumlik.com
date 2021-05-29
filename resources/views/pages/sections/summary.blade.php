<div class="summary summary-container">
    <div class="summary-header uppercase">{{ $summary->header }}</div>
    @foreach ($summary->items as $summaryItem)
    <a href="{{ $summaryItem->href }}">
        <div class="summary-item">
            <span class="summary-txt fas fa-info-circle capitalize">{!! $summaryItem->content !!}</span>
        </div>
    </a>
    @endforeach
</div>
