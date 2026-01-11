<isapp-analytics
        :charts='@json($charts)'
        :property-id="{{$property_id}}"
        start="{{$start}}"
        end="{{$end}}"
        url="{{ cp_route('isapp-ga.chart') }}"
/>
