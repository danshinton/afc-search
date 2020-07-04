@extends('layouts.app')

@section('content')
    <ul class="nav nav-tabs justify-content-center" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="search-tab" data-toggle="tab" href="#search" role="tab" aria-controls="search" aria-selected="true">Search</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources" aria-selected="false">Resources</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade text-center" id="resources" role="tabpanel" aria-labelledby="resources-tab">
            <div class="rl">
                <div class="rl-container">
                    <div class="rl-item">
                        <div class="hovereffect">
                            <img src="/images/afc-vol1-thumb.jpg" alt="The Apostolate's Family Catechism, Volume 1">
                            <div class="overlay">
                                <h2>The Apostolate's Family Catechism, Volume 1</h2>
                                @can('download-pdf')
                                    <a href="{{ route('download', '16431595-5175-44CE-A8A1-3F9A416A6BCC') }}" class="info">Download</a>
                                @else
                                    <a href="{{ route('login') }}" class="info">Login to Download</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="rl-item">
                        <div class="hovereffect">
                            <img src="/images/afc-vol2-thumb.jpg" alt="The Apostolate's Family Catechism, Volume 2">
                            <div class="overlay">
                                <h2>The Apostolate's Family Catechism, Volume 2</h2>
                                @can('download-pdf')
                                    <a href="{{ route('download', '9C3ABD70-56BA-40AB-BF9E-EA78A71977EA') }}" class="info">Download</a>
                                @else
                                    <a href="{{ route('login') }}" class="info">Login to Download</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="rl-item">
                        <div class="hovereffect">
                            <img src="/images/ccc-thumb.jpg" alt="Catechism of the Catholic Church">
                            <div class="overlay">
                                <h2>Catechism of the Catholic Church, Second Edition</h2>
                                <a href="http://ccc.usccb.org/flipbooks/catechism/index.html" target="_blank" class="info">Read</a>
                            </div>
                        </div>
                    </div>
                    <div class="rl-item">
                        <div class="hovereffect">
                            <img src="/images/compendium-thumb.jpg" alt="Compendium of the Catechism of the Catholic Church"><br/>
                            <div class="overlay">
                                <h2>Compendium of the Catechism of the Catholic Church</h2>
                                <a href="https://www.vatican.va/archive/compendium_ccc/documents/archive_2005_compendium-ccc_en.html" target="_blank" class="info">Read</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade show active" id="search" role="tabpanel" aria-labelledby="search-tab">
           <div class="s130">
                <form id="search-form" action="{{ route('question.query') }}" method="POST">
                    @csrf
                    <div style="text-align: center; padding-bottom: 20px">
                        <h1>Apostolate's Family Catechism Lookup</h1>
                    </div>
                    <div class="inner-form">
                        <div class="input-field first-wrap">
                            <div class="icon-wrapper">
                                <i class="fas fa-search fa-2x"></i>
                            </div>
                            <input id="paragraphs" type="text" placeholder="Enter your CCC paragraph numbers here" name="paragraphs"/>
                        </div>
                        <div class="input-field second-wrap">
                            <input id="search-button" class="btn-search" type="submit" value="SEARCH" disabled="disabled">
                        </div>
                    </div>
                    <span class="info">ex. 512,517-518</span>
                    <span class="float-right info mr-4"><a data-toggle="collapse" href="#suggested-searches" role="button" aria-expanded="false" class="flat"><i id="sugg-arrow" class="fas fa-caret-right nav-arrow"></i> Suggested Topics</a></span>
                    <div class="collapse mt-2 ml-4" id="suggested-searches" style="width: 95%">
                        <div class="card card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-2 p-0">
                                        <ul class="sugg-list">
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="359,375,399,404,518,635,655,766,1263,2361">Adam & Eve</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="1424,1449,1459,1483">Absolution</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="347,448,528,1078,1083,2628">Adoration</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="163,1028,1032,1045,1274,2090,2548,2550">Beatific Vision</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="735,826,864,953,1814,1818,1822-1829,1849,1889,2010,2090">Charity</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-4">
                                        <ul class="sugg-list">
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="1061-1065,2098,2560-2562,2564,2592,2664,2684,2725,2745,2786-2788">Christian Prayer</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="37,55-58,399,402-409,418">Consequences of Original Sin</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="53,122,708,1145,1950">Divine Pedagogy</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="242,252-254,267,685,689">Divine Persons of the Trinity</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="768,798-801,1830">Gifts of the Holy Spirit</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-3 pl-0">
                                        <ul class="sugg-list">
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="461-463,479,483">Incarnation</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="422-682">Jesus Christ</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="2482-2486,2505,1753,2151">Lying</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="356-361,705,1701-1709">Man as the Image of God</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="773,829,963-973">Mary and the Church</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-3">
                                        <ul class="sugg-list">
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="1601-1666">Matrimony</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="1855-1864,1867,1874">Mortal Sin</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="1032,1430,1460">Penance</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="695,1212-1419,1229-1233,1285,1322,1420">Sacraments of Initiation</a></li>
                                            <li><a href="#" class="sugg-topic flat" data-paragraphs="1928-1948">Social Justice</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="results">
                        @isset($results)
                            <h2>Results for query
                                @if($results->name)
                                    "{{ $results->name }}" <i class="fas fa-info-circle info-icon" data-toggle="tooltip" data-placement="top" title="CCC {{ $results->query }}"></i>
                                @else
                                    "{{ $results->query }}"
                                @endif
                            </h2>
                            <hr/>
                            @if($results->total != 0)
                                <div class="float-right text-center">
                                    <button id="copy-button" type="button" class="btn btn-copy"><i class="fas fa-copy"></i> Copy to Clipboard</button><br/>
                                    <span id="copy-result" style="display: none">Copied!</span>
                                </div>
                            @endif
                            <h3 style="margin-top: -0.3em; font-style: italic">
                                @if($results->total == 0)
                                    No results found
                                @elseif($results->total == 1)
                                    1 result found
                                @else
                                    {{ $results->total }} results found
                                @endif
                            </h3>
                            @if($results->total != 0)
                            <h2>Best Fit:</h2>
                            <ul id="best_fit_list">
                                @forelse($results->bestFit as $bestFit)
                                    <li>Question {{$bestFit->number}}: {{$bestFit->title}} (vol. {{$bestFit->volume}}, pg. {{$bestFit->page}})</li>
                                @empty
                                    <li>None</li>
                                @endforelse
                            </ul>
                            <h2>Related:</h2>
                            <ul id="related_list">
                                @forelse($results->related as $related)
                                    <li>Question {{$related->number}}: {{$related->title}} (vol. {{$related->volume}}, pg. {{$related->page}})</li>
                                @empty
                                    <li>None</li>
                                @endforelse
                            </ul>
                            @endif
                        @endisset
                    </div>
                    <input id="search-name" type="hidden" name="name"/>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="application/javascript">
        window.onload = function () {
            $(document).ready(function() {
                $('#copy-button').click(function() {
                    copyToClipboard();
                });

                $('#suggested-searches').on('hide.bs.collapse', function() {
                    $('#sugg-arrow').toggleClass('down');

                }).on('show.bs.collapse', function() {
                    $('#sugg-arrow').toggleClass('down');
                });

                $('.sugg-topic').click(function() {
                    search($(this).text(), $(this).data("paragraphs"));
                })

                $('[data-toggle="tooltip"]').tooltip()

                $('#paragraphs').on('keyup', function() {
                    if ($(this).val().length == 0) {
                        $('#search-button').attr('disabled', 'disabled');
                    } else {
                        $('#search-button').attr('disabled', false);
                    }
                });
            });
        }

        function copyToClipboard() {
            let text;

            text = 'Best Fit:\n';
            text += toTextList('best_fit_list');
            text += 'Related:\n';
            text += toTextList('related_list');

            let $tempInput = $("<textarea>");
            $("body").append($tempInput);
            $tempInput.text(text).select();
            document.execCommand("copy");
            $tempInput.remove();

            $('#copy-result').fadeIn(400).delay(1000).fadeOut(400);
        }

        function toTextList(source) {
            let text = "";

            $('#' + source).children().each(function() {
                text += " * " + $(this).text() + "\n"
            });

            return text;
        }

        function search(name, paragraphs) {
            $('#search-name').val(name);
            $('#paragraphs').val(paragraphs);
            $('#search-form').submit();
        }
    </script>
@endsection
