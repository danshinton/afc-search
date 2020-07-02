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
                <form action="{{ route('question.query') }}" method="POST">
                    @csrf
                    <div style="text-align: center; padding-bottom: 20px">
                        <h1>Apostolate's Family Catechism Lookup</h1>
                    </div>
                    <div class="inner-form">
                        <div class="input-field first-wrap">
                            <div class="icon-wrapper">
                                <i class="fas fa-search fa-2x"></i>
                            </div>
                            <input id="search" type="text" placeholder="Enter your CCC paragraph numbers here" name="paragraphs"/>
                        </div>
                        <div class="input-field second-wrap">
                            <input class="btn-search" type="submit" value="SEARCH">
                        </div>
                    </div>
                    <span class="info">ex. 512,517-518</span>
                    <div style="padding: 15px; line-height: 1.6em">
                        @isset($results)
                            @if($results->total != 0)
                                <div class="float-right text-center">
                                    <button type="button" onclick="copyToClipboard()" class="btn btn-copy"><i class="fas fa-copy"></i> Copy to Clipboard</button><br/>
                                    <span id="copy-result" style="display: none">Copied!</span>
                                </div>
                            @endif
                            <h2>Results for query "{{ $results->query }}"</h2>
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
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="application/javascript">
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
    </script>
@endsection
