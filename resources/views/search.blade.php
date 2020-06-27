    @extends('layouts.app')

    @section('content')
        <div class="s130">
            <form action="{{ route('question.query') }}" method="POST">
                @csrf
                <div style="text-align: center; padding-bottom: 20px">
                    <h1>Apostolate's Family Catechism Lookup</h1>
                </div>
                <div class="inner-form">
                    <div class="input-field first-wrap">
                        <div class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                            </svg>
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
                        <div>
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
                            <h2>Best Fit:</h2>
                            <ul>
                                @forelse($results->bestFit as $bestFit)
                                    <li>Question {{$bestFit->number}}: {{$bestFit->title}} (vol. {{$bestFit->volume}}, pg. {{$bestFit->page}})</li>
                                @empty
                                    <li>None</li>
                                @endforelse
                            </ul>
                        </div>
                        <div>
                            <h2>Related:</h2>
                            <ul>
                                @forelse($results->related as $related)
                                    <li>Question {{$related->number}}: {{$related->title}} (vol. {{$related->volume}}, pg. {{$related->page}})</li>
                                @empty
                                    <li>None</li>
                                @endforelse
                            </ul>
                        </div>
                    @endisset
                </div>
            </form>

        </div>

        <script src="js/extention/choices.js"></script>
    @endsection
