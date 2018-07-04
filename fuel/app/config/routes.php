<?php
return array(
    // FORMAT
    // key: URL string/pattern/?(/:param)
    // value: path/to/controller/action/$1

    // The default route (error it out)
    '_root_'  => 'api/alive',

    // The main 404 route
    '_404_'   => 'api/404',

    // cDVR Legacy MinMax Cleversafe Sites API - find sample min and max values with optional start/end date and region parameters
    'api/cdvr/legacy/cs/minmax/(/:region)?(/:start)?(/:end)?' =>
    'api/cdvr/legacy/cs/minmax/$1',

    // cDVR Legacy Cleversafe Sites API with optional date and region parameters
    'api/cdvr/legacy/cs/sites/(/:region)?(/:start)?(/:end)?' =>
    'api/cdvr/legacy/cs/sites/$1',

    // cDVR Legacy MinMax DDN Sites API - find sample min and max values with optional start/end date and region parameters
    'api/cdvr/legacy/ddn/minmax/(/:region)?(/:start)?(/:end)?' =>
    'api/cdvr/legacy/ddn/minmax/$1',

    // cDVR Legacy DDN Sites API with optional date and region parameters
    'api/cdvr/legacy/ddn/sites/(/:region)?(/:start)?(/:end)?' =>
    'api/cdvr/legacy/ddn/sites/$1',

    // cDVR Legacy Health API with optional date and region parameters
    'api/cdvr/legacy/health/(/:date)?(/:region)?' =>
    'api/cdvr/legacy/health/$1',

    // cDVR Legacy MinMax Peak Recorder Throughput API - find sample min and max values with optional start/end date and region parameters
    'api/cdvr/legacy/minmax/(/:region)?(/:start)?(/:end)?' =>
    'api/cdvr/legacy/minmax/$1',

    // cDVR Legacy Priority Market API - find sample min and max values with optional start/end date and region parameters
    'api/cdvr/legacy/priority/(/:start)?(/:end)?(/:region)?' =>
    'api/cdvr/legacy/priority/$1',

    // cDVR Legacy MinMax Recorder Throughput API - find sample min and max values with optional start/end date and region parameters
    'api/cdvr/legacy/recorders/minmax/(/:region)?(/:start)?(/:end)?' =>
    'api/cdvr/legacy/recorders/minmax/$1',

    // refactor cDVR Legacy Recorder Sites API with optional date and region parameters
    'api/cdvr/legacy/recorders/sites/(/:date)?' =>
    'api/cdvr/legacy/recorders/sites/$1',

    // cDVR Legacy Recorder Throughput API with optional date and region parameters
    'api/cdvr/legacy/recorders/throughput/(/:date)?(/:region)?' =>
    'api/cdvr/legacy/recorders/throughput/$1',

        // cDVR Legacy Trending API with optional component, date, and region parameters
    'api/cdvr/legacy/cs/trend/(/:start)?(/:end)?(/:region)?' =>
    'api/cdvr/legacy/cs/trend/$1',

       // cDVR Legacy Trending API with optional component, date, and region parameters
    'api/cdvr/legacy/ddn/trend/(/:start)?(/:end)?(/:region)?' =>
    'api/cdvr/legacy/ddn/trend/$1',

     // cDVR Legacy Trending API with optional component, date, and region parameters
    'api/cdvr/legacy/recorders/trend/(/:start)?(/:end)?(/:region)?' =>
    'api/cdvr/legacy/recorders/trend/$1',

    // comcast cDVR super8 fragment availibility API with optional start date, optional end date
    'api/cdvr/performance/super8/availability/(/:start)?(/:end)?' =>
    'api/cdvr/performance/super8/availability/$1',

    // iVOD Super8 Worst 10 Streams by Market API with optional date and region parameters
    'api/cdvr/performance/super8/hot/ivod(/:start)?(/:end)?' =>
    'api/cdvr/performance/super8/hot/ivod',

    // cDVR dash-r availability API - find sample min and max values with optional start/end date
    'api/cdvr/playback/dashr/availability/(/:start)?(/:end)?' =>
    'api/cdvr/playback/dashr/availability/$1',

    // cDVR Rio Failures at the Dash Origin Component API with optional date and region parameters
    'api/cdvr/performance/rio/failures/dashorigin(/:start)?(/:end)?(/:region)?' =>
    'api/cdvr/performance/rio/failures/dashorigin',

    // cDVR Rio Top 10 Error Codes by Count generated at rio components with optional count and date parameters
    'api/cdvr/performance/rio/failures/errorcodes/(/:count)?(/:date)?' =>
    'api/cdvr/performance/rio/failures/errorcodes/$1',

    // cDVR Rio performacen rio failures worst 5 streams with worst 5 markets
    'api/cdvr/performance/rio/failures/worst5streamswith5market/(/:region)?(/:start)?(/:end)?' =>
    'api/cdvr/performance/rio/failures/worst5streamswith5market/$1',

    // cDVR Rio Failures per Host API with optional count and date parameters
    'api/cdvr/performance/rio/failures/hosts/(/:count)?(/:date)?' =>
    'api/cdvr/performance/rio/failures/hosts/$1',

    // cDVR Rio Failures at the Market level API with optional date and region parameters
    'api/cdvr/performance/rio/failures/markets/(/:start)?(/:end)?(/:region)?' =>
    'api/cdvr/performance/rio/failures/markets',

    // cDVR Rio Failures at the Segment Recorder Component API with optional date and region parameters
    'api/cdvr/performance/rio/failures/segmentrecorder(/:start)?(/:end)?(/:region)?' =>
    'api/cdvr/performance/rio/failures/segmentrecorder',

    // cDVR Rio Failures at the Super 8 component API with optional date and region parameters
    'api/cdvr/performance/rio/failures/super8(/:start)?(/:end)?(/:region)?' =>
    'api/cdvr/performance/rio/failures/super8',

    // cDVR dash-r availability API - find sample min and max values with optional start/end date
    'api/cdvr/playback/dashr/worst/(/:start)?(/:end)?' =>
    'api/cdvr/playback/dashr/worst/$1',

    // cDVR dash-r worst10 recordingID API - find sample min and max values with optional start/end date
    'api/cdvr/playback/dashr/worst10/(/:count)?(/:date)?' =>
    'api/cdvr/playback/dashr/worst10/$1',

    // cDVR Rio Health API with optional date and region parameters
    'api/cdvr/rio/health/(/:date)?(/:region)?' =>
    'api/cdvr/rio/health/$1',

    // cDVR Count of Restarts at Rio Components with optional start date, end date, and region parameters
    'api/cdvr/rio/restarts/(/:region)?(/:start)?(/:end)?' =>
    'api/cdvr/rio/restarts/$1',

    // cDVR Rio Sites API with optional date and region parameters
    'api/cdvr/rio/sites/(/:date)?(/:region)?' =>
    'api/cdvr/rio/sites/$1',

    // cDVR Rio Trending API with optional date and region parameters
    'api/cdvr/rio/trending(/:start)?(/:end)?(/:region)?' =>
    'api/cdvr/rio/trending',

    // cDVR Rio Worst Capacity Utilization By Market
    'api/cdvr/rio/getworstfivecapacity/(/:start)?(/:end)?' =>
    'api/cdvr/rio/getworstfivecapacity/$1',

    // cLinear Combined Average Availability API with optional start date and end date parameters
    'api/clinear/combined/availability/average/comcast/(/:start)?(/:end)?' =>
    'api/clinear/combined/availability/average/comcast/$1',

        // cLinear Combined Average Availability API with optional start date and end date parameters
    'api/clinear/combined/availability/average/cox/(/:start)?(/:end)?' =>
    'api/clinear/combined/availability/average/cox/$1',

    // cLinear Combined Raw Availability API with optional start date and end date parameters,general
    'api/clinear/combined/availability/raw/comcast/(/:start)?(/:end)?' =>
    'api/clinear/combined/availability/raw/comcast/$1',

    // regional level raw data starts here.
    'api/clinear/combined/availability/raw/regioncomcast/(/:start)?(/:end)?' =>
    'api/clinear/combined/availability/raw/regioncomcast/$1',

    // cLinear Resolved Incidents Comcast Overview API with optional start date and end date parameters
    'api/clinear/incidents/components/comcast/(/:component)?(/:start)?(/:end)?' =>
    'api/clinear/incidents/components/comcast/$1',

    // cLinear Resolved Incidents cox Overview API with optional start date and end date parameters
    'api/clinear/incidents/components/cox(/:component)?(/:start)?(/:end)?' =>
    'api/clinear/incidents/components/cox',

    // cLinear Resolved Incidents shaw Overview API with optional start date and end date parameters
    'api/clinear/incidents/components/shaw(/:component)?(/:start)?(/:end)?' =>
    'api/clinear/incidents/components/shaw',

    // cLinear Duplicate Incidents Overview API with optional start date and end date parameters
    'api/clinear/incidents/duplicates(/:start)?(/:end)?' =>
    'api/clinear/incidents/duplicates',

    // cLinear Market-Incidents API with required start date, optional end date, and required region parameters
    // desired url format: /api/clinear/incidents/vendors/vendor/startDate/endDate
    'api/clinear/incidents/markets/comcast(/:market)?(/:start)?(/:end)?' =>
    'api/clinear/incidents/markets/comcast',

    // cLinear Resolved Incidents cox Overview API with optional start date and end date parameters
    'api/clinear/incidents/markets/cox(/:market)?(/:start)?(/:end)?' =>
    'api/clinear/incidents/markets/cox',

    // cLinear Resolved Incidents shaw Overview API with optional start date and end date parameters
    'api/clinear/incidents/markets/shaw(/:market)?(/:start)?(/:end)?' =>
    'api/clinear/incidents/markets/shaw',

    // cLinear Resolved Incidents Overview API with optional start date and end date parameters
    'api/clinear/incidents/notstarted(/:start)?(/:end)?' =>
    'api/clinear/incidents/notstarted',

    // cLinear Resolved Incidents Overview API with optional start date and end date parameters
    'api/clinear/incidents/resolved(/:start)?(/:end)?' =>
    'api/clinear/incidents/resolved',

    // cLinear nginx non-200 error codes API with optional start date and end date parameters
    'api/clinear/nginx/errors/non200/(/:start)?(/:end)?' =>
    'api/clinear/nginx/errors/non200/$1',

        // cLinear nginx regional availability API with optional start date and end date parameters
    'api/clinear/nginx/errors/availability/(/:start)?(/:end)?' =>
    'api/clinear/nginx/errors/availability/$1',

    // cLinear Pillar's Stream Availability API with optional start date and end date parameters
    'api/clinear/pillar/availability(/:start)?(/:end)?' =>
    'api/clinear/pillar/availability',

    // cLinear Pillar daily error free regions
    'api/clinear/pillar/errors/errorfree/(/:date)?' =>
    'api/clinear/pillar/errors/errorfree/$1',

    // cLinear pillar worst streams API with count, start date, and end date parameters
    'api/clinear/pillar/hot/hosts/cox/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/pillar/hot/hosts/cox/$1',

    // cLinear pillar worst streams API with count, start date, and end date parameters
    'api/clinear/pillar/hot/streams/comcast/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/pillar/hot/streams/comcast/$1',

    // cLinear pillar worst streams API with count, start date, and end date parameters
    'api/clinear/super8/hot/streams/worst100/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/super8/hot/streams/worst100/$1',

    // cLinear pillar worst streams API with count, start date, and end date parameters
    'api/clinear/pillar/hot/streams/cox(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/pillar/hot/streams/cox',

    // cLinear pillar worst Cox streams API with count, start date, and end date parameters
    'api/clinear/pillar/hot/streams/coxworst/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/pillar/hot/streams/coxworst/$1',


        // cLinear pillar's Manual Restart item numbers Overview API with count, start date, and end date parameters
    'api/clinear/pillar/restarts/comcast/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/pillar/restarts/comcast/$1',

    // cLinear pillar's Manual Restart item numbers Overview API with count, start date, and end date parameters
    'api/clinear/pillar/restarts/cox/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/pillar/restarts/cox/$1',

        // cLinear cox pillar's Manual Restart worst 10 item numbers Overview API with count, start date, and end date parameters
    'api/clinear/pillar/restarts/coxworst10/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/pillar/restarts/coxworst10/$1',

    // cLinear pillar's Manual Restart item numbers Overview API with count, start date, and end date parameters
    'api/clinear/pillar/restartscox/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/pillar/restartscox/$1',

       // cLinear player API with optional ,count start date and end date parameters
    'api/clinear/player/x2/hot/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/player/x2/hot/$1',

        // RLR - stream availability at CMC pillar nodes
    'api/clinear/rlr/cmc/pillar/availability/(/:start_date)?(/:end_date)?' =>
    'api/clinear/rlr/cmc/pillar/availability/$1',

        // RLR - worst 10 streams at CMC pillar nodes
    'api/clinear/rlr/cmc/pillar/worststreams/(/:start_date)?(/:end_date)?' =>
    'api/clinear/rlr/cmc/pillar/worststreams/$1',

            // RLR - stream availability at CMC super8 nodes
    'api/clinear/rlr/cmc/super8/availability/(/:start_date)?(/:end_date)?' =>
    'api/clinear/rlr/cmc/super8/availability/$1',

            // RLR - worst 10 streams at CMC super8 nodes
    'api/clinear/rlr/cmc/super8/worststreams/(/:start_date)?(/:end_date)?' =>
    'api/clinear/rlr/cmc/super8/worststreams/$1',

                // RLR - stream availability at CMC varnish nodes
    'api/clinear/rlr/cmc/varnish/availability/(/:start_date)?(/:end_date)?' =>
    'api/clinear/rlr/cmc/varnish/availability/$1',

            // RLR - worst 10 streams at CMC varnish nodes
    'api/clinear/rlr/cmc/super8/worststreams/(/:start_date)?(/:end_date)?' =>
    'api/clinear/rlr/cmc/varnish/worststreams/$1',

    // desired url format: /api/clinear/sscanner/availability/cox/count/startDate/endDate
    'api/clinear/sscanner/availability/cox(/:start)?(/:end)?' =>
    'api/clinear/sscanner/availability/cox',

    // cLinear Market-Incidents API with required start date and region parameters and optional end date
    // // desired url format: /api/clinear/incidents/sscanner/availability/startDate/endDate
    'api/clinear/sscanner/availability(/:start)?(/:end)?' =>
    'api/clinear/sscanner/availability',

    // cLinear stream scanner worst streams API with count, start date, and end date parameters
    'api/clinear/sscanner/hot/comcast(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/sscanner/hot/comcast',

    // cLinear stream scanner worst streams API with count, start date, and end date parameters
    'api/clinear/sscanner/hot/cox(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/sscanner/hot/cox',

    // cLinear stream scanner worst streams API with count, start date, and end date parameters
    'api/clinear/sscanner/markets/cox(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/sscanner/markets/cox',

        // comcast cLinear super8 fragment availibility API with required start date, optional end date, and required region parameters
    'api/clinear/super8/availability/comcast/(/:start)?(/:end)?' =>
    'api/clinear/super8/availability/comcast/$1',

        // cox cLinear super8 fragment availibility API with required start date, optional end date, and required region parameters
    'api/clinear/super8/availability/cox/(/:start)?(/:end)?' =>
    'api/clinear/super8/availability/cox/$1',

    // cLinear super8 top 10 errors API with count, start date, and end date parameters
    'api/clinear/super8/errors/top/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/super8/errors/top/$1',

    // cLinear super8 worst streams API with count, start date, and end date parameters
    'api/clinear/super8/hot/streams/worst100/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/super8/hot/streams/worst100/$1',

        // comcast cLinear super8 worst issues API with count, start date, and end date parameters
    'api/clinear/super8/hot/comcast/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/super8/hot/comcast/$1',

    // cox cLinear super8 worst issues API with count, start date, and end date parameters
    'api/clinear/super8/hot/cox/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/super8/hot/cox/$1',

        // cLinear super8 worst error codes by region API with optional start date and end date parameters
    'api/clinear/super8/hot/error/codes/(/:start)?(/:end)?' =>
    'api/clinear/super8/hot/error/codes/$1',

     // comcast cLinear super8 fragment availibility API with required start date, optional end date, and required region parameters
    'api/clinear/super8/trending/comcast/(/:start)?(/:end)?(/:facility)?(/:region)?' =>
    'api/clinear/super8/trending/comcast/$1',

    // cLinear transcoder worst issues API with count, start date, and end date parameters
    'api/clinear/transcoder/alarms/hot/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/transcoder/alarms/hot/$1',

    // cLinear transcoder region  alarm API with  start date, and end date parameters
    'api/clinear/transcoder/alarms/region/(/:start)?(/:end)?' =>
    'api/clinear/transcoder/alarms/region/$1',

    // cLinear transcoder region  continuity API with  start date, and end date parameters
    'api/clinear/transcoder/continuity/hot/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/transcoder/continuity/hot/$1',

    // cLinear transcoder region  continuity API with  start date, and end date parameters
    'api/clinear/transcoder/continuity/region/(/:start)?(/:end)?' =>
    'api/clinear/transcoder/continuity/region/$1',

     // cLinear transcoder pid API with  start date, and end date parameters
    'api/clinear/transcoder/pid/availability/(/:start)?(/:end)?' =>
    'api/clinear/transcoder/pid/availability/$1',

    // cLinear transcoder region  pid API with  start date, and end date parameters
    'api/clinear/transcoder/pid/hot/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/transcoder/pid/hot/$1',

    // cLinear varnish stream availability API with count, start date, and end date parameters
    'api/clinear/varnish/availability/(/:start)?(/:end)?' =>
    'api/clinear/varnish/availability/$1',

    // cLinear varnish cache streams API with count, start date, and end date parameters
    'api/clinear/varnish/cachestreams/hot(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/varnish/cachestreams/hot',

    // cLinear varnish worst streams API with count, start date, and end date parameters
    'api/clinear/varnish/hot/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/varnish/hot/$1',

    // cLinear varnish worst streams API with count, start date, and end date parameters
    'api/clinear/varnish/worst100/(/:count)?(/:start)?(/:end)?' =>
    'api/clinear/varnish/worst100/$1',

        // cLinear varnish - streams with worst response time - API with count, start date, and end date parameters
    'api/clinear/varnish/worst10responsetime/(/:start)?(/:end)?' =>
    'api/clinear/varnish/worst10responsetime/$1',

            // cLinear varnish - streams with worst response time - API with count, start date, and end date parameters
    'api/clinear/varnish/regionalresponsetimeavg(/:region)?(/:start)?(/:end)?' =>
    'api/clinear/varnish/regionalresponsetimeavg',

    // viper subscriber API with count, start date, and end date parameters
    'api/combined/subscriber/counts/region/(/:flag)?(/:start)?(/:end)?' =>
    'api/combined/subscriber/counts/region/$1',

    // viper super8 Daily  API with count, start date, and end date parameters
    'api/combined/super8/errors/summary(/:count)?(/:region)?(/:start)?(/:end)?' =>
    'api/combined/super8/errors/summary',

    // viper super8 Daily  errors summary  for cdvr API with count, start date, and end date parameters
    'api/combined/super8/errors/cdvr/(/:start)?(/:end)?' =>
    'api/combined/super8/errors/cdvr/$1',

        // viper super8 Daily  errors summary  for cLinear API with count, start date, and end date parameters
    'api/combined/super8/errors/clinear/(/:start)?(/:end)?' =>
    'api/combined/super8/errors/clinear/$1',

        // viper super8 Daily  errors summary  for ivod API with count, start date, and end date parameters
    'api/combined/super8/errors/ivod/(/:start)?(/:end)?' =>
    'api/combined/super8/errors/ivod/$1',


        // viper super8 API with platform, start date, and end date parameters
    'api/combined/super8/errors/top10(/:platform)?(/:start)?(/:end)?' =>
    'api/combined/super8/errors/top10',

    // Software Versions API with optional date and region parameters
    'api/os/versions(/:region)?(/:start)?(/:end)?' =>
    'api/os/versions',

    // viper team Planned work summary with count, start date, and end date parameters
    'api/planned/impactedservices/(/:platform)?(/:start)?(/:end)?' =>
    'api/planned/impactedservices/$1',

    // Viper ops team RCA-specific  Planned work summary with count, start date, and end date parameters
    'api/planned/worktype(/:request)?(/:start)?(/:end)?' =>
    'api/planned/worktype',


    // headwaters overall device availability, with date 7 day
    'api/player/overallavailability/(/:start)?(/:end)?' =>
    'api/player/overallavailability/$1',

    // headwaters trend between start and end date, default last 7 days
    'api/player/trendregion/(/:start_date)?(/:end_date)?' =>
    'api/player/trendregion/$1',

    // headwaters worst n stream data, with date and count, default worst 10 for yesterday
    'api/player/worststreams/(/:count)?(/:date)?' =>
    'api/player/worststreams/$1',

        // cLinear varnish cache hit/miss success rate API with start date, and end date parameters
    'api/clinear/varnish/cache/efficiency/(/:start)?(/:end)?' =>
    'api/clinear/varnish/cache/efficiency/$1',

      // cLinear  2e2 API with start date, and end date parameters
    'api/clinear/player/x2/e2e(/:start)?(/:end)?' =>
    'api/clinear/player/x2/e2e',

    // cLinear  rio A8 tend API with start date, and end date parameters
    'api/cdvr/performance/rio/a8/trend(/:start)?(/:end)?' =>
    'api/cdvr/performance/rio/a8/trend',

        // cLinear  rio c3rm tend API with start date, and end date parameters
    'api/cdvr/performance/rio/c3rm/trend(/:start)?(/:end)?' =>
    'api/cdvr/performance/rio/c3rm/trend',

    // Pillar channel panics from daily report API with start and end date
    'api/clinear/pillar/pillardaily/panicscause/(/:start_date)?(/:end_date)?' =>
    'api/clinear/pillar/pillardaily/panicscause/$1',

    // cLinear Resolved Incidents Comcast Overview API with optional start date and end date parameters
    'api/snow/incidents/comcast/linear/t6tve/impactedservices/(/:start)?(/:end)?' =>
    'api/snow/incidents/comcast/linear/t6tve/impactedservices/$1',

        // cLinear Resolved Incidents Comcast Overview API with optional start date and end date parameters
    'api/snow/incidents/comcast/linear/t6tve/elements/(/:start)?(/:end)?' =>
    'api/snow/incidents/comcast/linear/t6tve/elements/$1'

);
