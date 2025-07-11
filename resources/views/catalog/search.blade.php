
<div class="position-relative overflow-hidden p-3 p-md-4 m-md-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <form method="GET" action="{{ route('catalog', request()->query()) }}" class="position-relative">
                <div class="card-body row align-items-center">
                    <div class="col-12">
                        @foreach (request()->query() as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <div class="position-relative">
                            <input id="search-input" class="form-control form-control-lg form-control-borderless"
                                   type="search" name="q" value="{{ request()->get('q') }}"
                           placeholder="Поиск по тестам">
                            <div class="search-icon">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>







