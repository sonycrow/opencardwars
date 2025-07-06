<div>
    <div class="card flex"
         data-cardid="{{ $card['id'].'-'.$lang }}"
         data-number="{{ $card['number'] }}">

        <div class="art" style="background-image: url('{{ Vite::asset('resources/art/' . $card['universe'] . "/" . Str::lower($card['universe'] . '-' . $card['set'] . $card['number'] . '-' . $card['version']) . ".jpg") }}')"></div>
{{--        <div class="art-details" style="background-image: url('{{ Vite::asset('resources/art/' . $card['universe'] . "/" . Str::lower($card['universe'] . '-' . $card['set'] . $card['number'] . '-' . $card['version']) . ".png") }}')"></div>--}}

        <div class="elements elements-equip">
            <div class="card-name">{{ $card['name'][$lang] }}</div>
            <div class="card-cost">
                @for ($i = 0; $i < $card['cost']; $i++)
                    <div class="text"></div>
                @endfor
            </div>
        </div>

        <div class="stats-equip">
            <div class="name">{{ $card['name'][$lang] }}</div>
            <div class="attack"><span class="equip-plus">+</span>{{ $card['atk'] }}</div>
            <div class="defense"><span class="equip-plus">+</span>{{ $card['def'] }}</div>
        </div>

        <div class="skill-group">
            <div class="skill-container skill-container-{{ $card['type'] }}">

                <div class="skill-traits text">
                    [{{ $card['class_text'] }}]&nbsp;
                    
                    @if (!empty($card['traits']))
                        @foreach($card['traits'] as $trait)
                            [{{ $trait }}]&nbsp;
                        @endforeach
                    @endif
                    @if (!empty($card['skills']))
                        @foreach ($card['skills'] as $skill)
                            {{{ $skill }}}&nbsp;
                        @endforeach
                    @endif
                </div>

                <div class="skill-extra">
                    <div class="skill-line">
                        <div class="line">EXTRA</div>
                        <div class="cost text">{{ $card['extra']['cost'] }}</div>
                        <div class="skills text">
                            @foreach($card['extra']['skills'] as $skill)
                                {{ '{' . $skill . '}' }}
                            @endforeach
                        </div>
                    </div>
                    <div class="skill-description-back"><div class="text">{{ $card['extra']['desc'][$lang] }}</div></div>
                    <div class="skill-description"><div class="text">{{ $card['extra']['desc'][$lang] }}</div></div>
                </div>

            </div>
        </div>

        <div class="cardnumber text">
            [{{ $card['type_text'] }}]
            OPEN CARD WARS {{ Str::upper($card['id'].'-'.$lang) }}
        </div>
    </div>
</div>
