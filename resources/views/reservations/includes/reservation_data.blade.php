    <div id="announcement_data">
        <div class="card-body p-3">
            @foreach(array_chunk(App\Constants\GlobalConstants::LIST_TIMES,6) as $timesChunk)
                <div class="row text-center mx-0">
                    @foreach($timesChunk as $time)
                        @if($reservations->contains('time',$time))
                            <div class="col-md-2 col-4 my-1 px-2">
                                <div class="cell test1 py-1">
                                    {{$time}}
                                </div>
                            </div>
                        @else
                            <div class="col-md-2 col-4 my-1 px-2">

                                <div class="cell py-1">
                                    <div class="text-center">

                                        <input type="checkbox" name="time[]" id="time" style="width: 50px; border-radius: 0"
                                               value="{{$time}}">
                                        {{$time}}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
            <div class="text-center">
                <p class="text-justify text-danger testt" hidden> Select at least one reservation time </p>
            </div>
        </div>
    </div>

