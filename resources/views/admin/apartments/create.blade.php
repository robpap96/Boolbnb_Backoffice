@extends('layouts.main-dashboard')

@section('page-title')
    | Nuovo appartamento
@endsection

@section('content')
    <div id="admin-apartments-create">
        <h1>Creazione di un nuovo appartamento</h1>

        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Titolo appartamento --}}
            <div class="mb-3">
                <label for="title" class="form-label">Titolo riepilogativo che descriva l’appartamento*</label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Titolo" minlength="5" maxlength="150" required>
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Indirizzo completo --}}
            <div class="mb-3">
                <label for="full_address" class="form-label">Indirizzo completo*</label>
                <input type="text" id="full_address" name="full_address" class="form-control @error('full_address') is-invalid @enderror" value="{{ old('full_address') }}" placeholder="Indirizzo completo" required>
                @error('full_address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="map-view-container">
                    <div class='map-view my-4'>
                        <div class='tt-side-panel'>
                            <header class='tt-side-panel__header'>
                            </header>
                            <div class='tt-tabs js-tabs'>
                                <div class='tt-tabs__panel'>
                                    <div class='js-results' hidden='hidden'></div>
                                    <div class='js-results-loader' hidden='hidden'>
                                        <div class='loader-center'><span class='loader'></span></div>
                                    </div>
                                    <div class='tt-tabs__placeholder js-results-placeholder'></div>
                                </div>
                            </div>
                        </div>
                        <div id='map' class='full-map'></div>
                    </div>
                </div>
            </div>

            {{-- Numero di stanze --}}
            <div class="mb-3">
                <label for="rooms_num" class="form-label">Numero di stanze*</label>
                <input type="number" id="rooms_num" name="rooms_num" class="form-control @error('rooms_num') is-invalid @enderror" value="{{ old('rooms_num') }}" placeholder="Numero di stanze" min="1" max="15" required>
                @error('rooms_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Numero di letti --}}
            <div class="mb-3">
                <label for="beds_num" class="form-label">Numero di letti*</label>
                <input type="number" id="beds_num" name="beds_num" class="form-control @error('beds_num') is-invalid @enderror" value="{{ old('beds_num') }}" placeholder="Numero di letti" min="1" max="15" required>
                @error('beds_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Numero di bagni --}}
            <div class="mb-3">
                <label for="baths_num" class="form-label">Numero di bagni*</label>
                <input type="number" id="baths_num" name="baths_num" class="form-control @error('baths_num') is-invalid @enderror" value="{{ old('baths_num') }}" placeholder="Numero di bagni" min="1" max="15" required>
                @error('baths_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Metri quadrati totali --}}
            <div class="mb-3">
                <label for="mq" class="form-label">Metri quadrati totali*</label>
                <input type="number" id="mq" name="mq" class="form-control @error('mq') is-invalid @enderror" value="{{ old('mq') }}" placeholder="Metri quadrati" min="1" max="15000" required>
                @error('mq')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Prezzo a notte --}}
            <div class="mb-3">
                <label for="price" class="form-label">Prezzo a notte*</label>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Prezzo" min="1" max="10000" step=".01" required>
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Checkboxes with services --}}
            <div class="my-3 ">
                <div>
                    <label class="form-label">Lista servizi:</label>
                    @error('services')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                @foreach ($services as $service)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="service-{{ $service->name }}" name="services[]" value="{{ $service->id }}" {{ in_array($service->id, old('services', [])) ? 'checked' : null }}>
                        <label class="form-check-label" for="service-{{ $service->name }}">{{ $service->name }}</label>
                    </div>
                @endforeach
            </div>

            {{-- Descrizione appartamento --}}
            <div class="mb-3">
                <label for="description" class="form-label">Descrizione*</label>
                <textarea name="description" id="description" cols="20" rows="3" class="form-control @error('description') is-invalid @enderror" required placeholder="Breve descrizione dell'appartamento">{{ old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- Immagine dell'appartamento --}}
            <div class="mb-3 d-flex">
                <div class="col-6">
                    <label for="image" class="form-label">Immagine rappresentativa dell’appartamento*</label>
                    <input type="file" id="image" name="image" required class="form-control  @error('image') is-invalid @enderror" onchange="loadFile(event)">
                    @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 p-4">
                    <img id="output" src="" class="fluid-img w-100">
                </div>
    
                <script>
                    var loadFile = function(event) {
                        var reader = new FileReader();
                        reader.onload = function(){
                            var output = document.getElementById('output');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    };
                </script>
            </div>

            {{-- Switch button per la visibilità si/no --}}
            @if ($errors->any())
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_visible" name="is_visible" {{ old('is_visible') ? 'checked' : ''}}>
                    <label class="form-check-label" for="is_visible">Appartmento visibile si/no</label>
                </div>
            @else 
                <div class="mb-3 form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_visible" name="is_visible" checked>
                    <label class="form-check-label" for="is_visible">Appartmento visibile si/no</label>
                </div>
            @endif

            <button type="submit" class="btn btn-success">Crea</button>
            <button type="reset" class="btn btn-secondary">Ripulisci tutti i campi</button>
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-danger">Annulla creazione</a>
        </form>
    </div>    
    
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/maps/maps-web.min.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/services/services-web.min.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.2.0//SearchBox-web.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/6.x/6.23.0//examples/pages/examples/assets/js/search-markers/search-marker.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/6.x/6.23.0//examples/pages/examples/assets/js/search/search-results-parser.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/6.x/6.23.0//examples/pages/examples/assets/js/search-markers/search-markers-manager.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/6.x/6.23.0//examples/pages/examples/assets/js/info-hint.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/6.x/6.23.0//examples/pages/examples/assets/js/mobile-or-tablet.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/6.x/6.23.0//examples/pages/examples/assets/js/search/results-manager.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/6.x/6.23.0//examples/pages/examples/assets/js/search/side-panel.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/6.x/6.23.0//examples/pages/examples/assets/js/search/dom-helpers.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/6.x/6.23.0//examples/pages/examples/assets/js/formatters.js"></script>
    
    <script>
        tt.setProductInfo('Codepen Examples', '${analytics.productVersion}');
    var map = tt.map({
        key: 'S7Di8WQbB2pqxqTH8RYmhO63cZwgtNgp',
        container: 'map',
        center: [15.4, 53.0],
        zoom: 3,
        dragPan: !window.isMobileOrTablet()
    });
    var infoHint = new InfoHint('info', 'bottom-center', 5000).addTo(document.getElementById('map'));
    var errorHint = new InfoHint('error', 'bottom-center', 5000).addTo(document.getElementById('map'));
    // Options for the fuzzySearch service
    var searchOptions = {
        key: 'S7Di8WQbB2pqxqTH8RYmhO63cZwgtNgp',
        language: 'en-GB',
        limit: 5
    };
    // Options for the autocomplete service
    var autocompleteOptions = {
        key: 'S7Di8WQbB2pqxqTH8RYmhO63cZwgtNgp',
        language: 'en-GB'
    };
    var searchBoxOptions = {
        minNumberOfCharacters: 0,
        searchOptions: searchOptions,
        autocompleteOptions: autocompleteOptions,
        distanceFromPoint: [15.4, 53.0]
    };
    var ttSearchBox = new tt.plugins.SearchBox(tt.services, searchBoxOptions);
    document.querySelector('.tt-side-panel__header').appendChild(ttSearchBox.getSearchBoxHTML());
    var state = {
        previousOptions: {
            query: null,
            center: null
        },
        callbackId: null,
        userLocation: null
    };
    map.addControl(new tt.FullscreenControl({container: document.querySelector('body')}));
    map.addControl(new tt.NavigationControl());
    new SidePanel('.tt-side-panel', map);
    var geolocateControl = new tt.GeolocateControl({
        positionOptions: {
            enableHighAccuracy: false
        }
    });
    geolocateControl.on('geolocate', function(event) {
        var coordinates = event.coords;
        state.userLocation = [coordinates.longitude, coordinates.latitude];
        ttSearchBox.updateOptions(Object.assign({}, ttSearchBox.getOptions(), {
            distanceFromPoint: state.userLocation
        }));
    });
    map.addControl(geolocateControl);
    var resultsManager = new ResultsManager();
    var searchMarkersManager = new SearchMarkersManager(map);
    map.on('load', handleMapEvent);
    map.on('moveend', handleMapEvent);
    ttSearchBox.on('tomtom.searchbox.resultscleared', handleResultsCleared);
    ttSearchBox.on('tomtom.searchbox.resultsfound', handleResultsFound);
    ttSearchBox.on('tomtom.searchbox.resultfocused', handleResultSelection);
    ttSearchBox.on('tomtom.searchbox.resultselected', handleResultSelection);
    function handleMapEvent() {
        // Update search options to provide geobiasing based on current map center
        var oldSearchOptions = ttSearchBox.getOptions().searchOptions;
        var oldautocompleteOptions = ttSearchBox.getOptions().autocompleteOptions;
        var newSearchOptions = Object.assign({}, oldSearchOptions, { center: map.getCenter() });
        var newAutocompleteOptions = Object.assign({}, oldautocompleteOptions, { center: map.getCenter() });
        ttSearchBox.updateOptions(Object.assign({}, searchBoxOptions, {
            placeholder: 'Query e.g. Washington',
            searchOptions: newSearchOptions,
            autocompleteOptions: newAutocompleteOptions,
            distanceFromPoint: state.userLocation
        }));
    }
    function handleResultsCleared() {
        searchMarkersManager.clear();
        resultsManager.clear();
    }
    function handleResultsFound(event) {
        // Display fuzzySearch results if request was triggered by pressing enter
        if (event.data.results && event.data.results.fuzzySearch && event.data.metadata.triggeredBy === 'submit') {
            var results = event.data.results.fuzzySearch.results;
            if (results.length === 0) {
                handleNoResults();
            }
            searchMarkersManager.draw(results);
            resultsManager.success();
            fillResultsList(results);
            fitToViewport(results);
        }
        if (event.data.errors) {
            errorHint.setMessage('There was an error returned by the service.');
        }
    }
    function handleResultSelection(event) {
        if (isFuzzySearchResult(event)) {
            // Display selected result on the map
            var result = event.data.result;
            resultsManager.success();
            searchMarkersManager.draw([result]);
            fillResultsList([result]);
            searchMarkersManager.openPopup(result.id);
            fitToViewport(result);
            state.callbackId = null;
            infoHint.hide();
        } else if (stateChangedSinceLastCall(event)) {
            var currentCallbackId = Math.random().toString(36).substring(2, 9);
            state.callbackId = currentCallbackId;
            // Make fuzzySearch call with selected autocomplete result as filter
            handleFuzzyCallForSegment(event, currentCallbackId);
        }
    }
    function isFuzzySearchResult(event) {
        return !('matches' in event.data.result);
    }
    function stateChangedSinceLastCall(event) {
        return Object.keys(searchMarkersManager.getMarkers()).length === 0 || !(
            state.previousOptions.query === event.data.result.value &&
            state.previousOptions.center.toString() === map.getCenter().toString());
    }
    function getBounds(data) {
        var southWest;
        var northEast;
        if (data.viewport) {
            southWest = [data.viewport.topLeftPoint.lng, data.viewport.btmRightPoint.lat];
            northEast = [data.viewport.btmRightPoint.lng, data.viewport.topLeftPoint.lat];
        }
        return [southWest, northEast];
    }
    function fitToViewport(markerData) {
        if (!markerData || markerData instanceof Array && !markerData.length) {
            return;
        }
        var bounds = new tt.LngLatBounds();
        if (markerData instanceof Array) {
            markerData.forEach(function(marker) {
                bounds.extend(getBounds(marker));
            });
        } else {
            bounds.extend(getBounds(markerData));
        }
        map.fitBounds(bounds, { padding: 100, linear: true });
    }
    function handleFuzzyCallForSegment(event, currentCallbackId) {
        var query = ttSearchBox.getValue();
        var segmentType = event.data.result.type;
        var commonOptions = Object.assign({}, searchOptions, {
            query: query,
            limit: 15,
            center: map.getCenter(),
            typeahead: true,
            language: 'en-GB'
        });
        var filter;
        if (segmentType === 'category') {
            filter = { categorySet: event.data.result.id };
        }
        if (segmentType === 'brand') {
            filter = { brandSet: event.data.result.value };
        }
        var options = Object.assign({}, commonOptions, filter);
        infoHint.setMessage('Loading results...');
        errorHint.hide();
        resultsManager.loading();
        tt.services.fuzzySearch(options)
            .then(function(response) {
                if (state.callbackId !== currentCallbackId) {
                    return;
                }
                if (response.results.length === 0) {
                    handleNoResults();
                    return;
                }
                resultsManager.success();
                searchMarkersManager.draw(response.results);
                fillResultsList(response.results);
                map.once('moveend', function() {
                    state.previousOptions = {
                        query: query,
                        center: map.getCenter()
                    };
                });
                fitToViewport(response.results);
            })
            .catch(function(error) {
                if (error.data && error.data.errorText) {
                    errorHint.setMessage(error.data.errorText);
                }
                resultsManager.resultsNotFound();
            })
            .finally(function() {
                infoHint.hide();
            });
    }
    function handleNoResults() {
        resultsManager.clear();
        resultsManager.resultsNotFound();
        searchMarkersManager.clear();
        infoHint.setMessage(
            'No results for "' +
            ttSearchBox.getValue() +
            '" found nearby. Try changing the viewport.'
        );
    }
    function fillResultsList(results) {
        resultsManager.clear();
        var resultList = DomHelpers.createResultList();
        results.forEach(function(result) {
            var distance = state.userLocation ? SearchResultsParser.getResultDistance(result) : undefined;
            var addressLines = SearchResultsParser.getAddressLines(result);
            var searchResult = this.DomHelpers.createSearchResult(
                addressLines[0],
                addressLines[1],
                distance ? Formatters.formatAsMetricDistance(distance) : ''
            );
            var resultItem = DomHelpers.createResultItem();
            resultItem.appendChild(searchResult);
            resultItem.setAttribute('data-id', result.id);
            resultItem.onclick = function(event) {
                var id = event.currentTarget.getAttribute('data-id');
                searchMarkersManager.openPopup(id);
                searchMarkersManager.jumpToMarker(id);
            };
            resultList.appendChild(resultItem);
        });
        resultsManager.append(resultList);
    }
    </script>
@endsection