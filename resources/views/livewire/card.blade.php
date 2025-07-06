<div>
    <div class="card flex"
         data-cardid="{{ $card['id'].'-'.$lang }}"
         data-number="{{ $card['number'] }}">

        <div class="art" style="background-image: url('{{ Vite::asset('resources/art/' . $card['universe'] . "/" . Str::lower($card['universe'] . '-' . $card['set'] . $card['number'] . '-' . $card['version']) . ".jpg") }}')"></div>
{{--        <div class="art-details" style="background-image: url('{{ Vite::asset('resources/art/' . $card['universe'] . "/" . Str::lower($card['universe'] . '-' . $card['set'] . $card['number'] . '-' . $card['version']) . ".png") }}')"></div>--}}

        <div class="elements elements-{{ $card['class'] }}"></div>

        <div class="card-name">{{ $card['name'][$lang] }}</div>
        <div class="card-cost">
            @for ($i = 0; $i < $card['cost']; $i++)
                <div class="text"></div>
            @endfor
        </div>

        <div class="hp">{{ $card['hp'] }}</div>
        <div class="attack">{{ $card['atk'] }}</div>
        <div class="defense">{{ $card['def'] }}</div>

        <div class="skill-group">
            <div class="skill-container">

                <div class="skill-traits text">
                    [{{ $card['class_text'] }}]&nbsp;
                    @foreach($card['traits'] as $trait)
                        [{{ $trait }}]&nbsp;
                    @endforeach
                    @foreach ($card['skills'] as $skill)
                        {{{ $skill }}}&nbsp;
                    @endforeach
                </div>

                <div class="skill-vanguard">
                    <div class="skill-line">
                        <div class="line">{{ __('card.vanguard') }}</div>
                        <div class="cost text">{{ $card['vanguard']['cost'] }}</div>
                        <div class="skills text">
                            @foreach($card['vanguard']['skills'] as $skill)
                                {{ '{' . $skill . '}' }}
                            @endforeach
                        </div>
                    </div>
                    <div class="skill-description-back"><div class="text">{{ $card['vanguard']['desc'][$lang] }}</div></div>
                    <div class="skill-description"><div class="text">{{ $card['vanguard']['desc'][$lang] }}</div></div>
                </div>

                <div class="skill-center">
                    <div class="skill-line">
                        <div class="line">{{ __('card.center') }}</div>
                        <div class="cost text">{{ $card['center']['cost'] }}</div>
                        <div class="skills text">
                            @foreach($card['center']['skills'] as $skill)
                                {{ '{' . $skill . '}' }}
                            @endforeach
                        </div>
                    </div>
                    <div class="skill-description-back"><div class="text">{{ $card['center']['desc'][$lang] }}</div></div>
                    <div class="skill-description"><div class="text">{{ $card['center']['desc'][$lang] }}</div></div>
                </div>

                <div class="skill-rearguard">
                    <div class="skill-line">
                        <div class="line">{{ __('card.rearguard') }}</div>
                        <div class="cost text">{{ $card['rearguard']['cost'] }}</div>
                        <div class="skills text">
                            @foreach($card['rearguard']['skills'] as $skill)
                                {{ '{' . $skill . '}' }}
                            @endforeach
                        </div>
                    </div>
                    <div class="skill-description-back"><div class="text">{{ $card['rearguard']['desc'][$lang] }}</div></div>
                    <div class="skill-description"><div class="text">{{ $card['rearguard']['desc'][$lang] }}</div></div>
                </div>

            </div>
        </div>

        <div class="cardnumber text">
            [{{ $card['type_text'] }}]
            OPEN CARD WARS {{ Str::upper($card['id'].'-'.$lang) }}
        </div>
    </div>
</div>
