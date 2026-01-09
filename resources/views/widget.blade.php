<isapp-google-analytics
        :charts='@json($charts)'
        property-id="{{$property_id}}"
        url="{{ cp_route('isapp-ga.chart') }}"
/>
