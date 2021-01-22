<nav aria-label="Search Table Pagination">
    <ul class="pagination justify-content-center mt-2">
        <li class="page-item @if($bot == 1) disabled @endif">
            <a class="page-link" href="#" @if($bot == 1) aria-disabled="true" @endif onclick="getPrev()">Previous</a>
        </li>
        <li class="page-item disabled">
            <span class="page-link">{{ 'Showing '.$bot.'-'.$top.' of '.$total }}</span>
        </li>
        <li class="page-item @if($top == $total) disabled @endif">
            <a class="page-link" href="#" @if($top == $total) aria-disabled="true" @endif onclick="getNext()">Next</a>
        </li>
    </ul>
</nav>