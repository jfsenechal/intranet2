<table cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #333; line-height: 1.4;">
    <tr>
        <td style="padding-right: 15px; vertical-align: top;">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $logoTitle }}" style="max-width: 120px; height: auto; display: block;"/>
            @endif
        </td>
        <td style="vertical-align: top; border-left: 2px solid #d4a017; padding-left: 15px;">
            <div style="font-size: 14px; font-weight: bold; color: #000;">
                {{ $signature->prenom }} {{ $signature->nom }}
            </div>
            @if ($signature->fonction)
                <div style="font-style: italic;">{{ $signature->fonction }}</div>
            @endif
            @if ($signature->service)
                <div>{{ $signature->service }}</div>
            @endif
            @if ($logoTitle)
                <div style="font-weight: bold; margin-top: 4px;">{{ $logoTitle }}</div>
            @endif
            <div style="margin-top: 6px;">
                {{ $signature->adresse }} &mdash; {{ $signature->code_postal }} {{ $signature->localite }}
            </div>
            <div style="margin-top: 4px;">
                @if ($signature->telephone)
                    <span>Tél. : <a href="tel:{{ $signature->telephone }}" style="color: #333; text-decoration: none;">{{ $signature->telephone }}</a></span>
                @endif
                @if ($signature->gsm)
                    <span style="margin-left: 8px;">GSM : <a href="tel:{{ $signature->gsm }}" style="color: #333; text-decoration: none;">{{ $signature->gsm }}</a></span>
                @endif
                @if ($signature->fax)
                    <span style="margin-left: 8px;">Fax : {{ $signature->fax }}</span>
                @endif
            </div>
            <div>
                <a href="mailto:{{ $signature->email }}" style="color: #d4a017; text-decoration: none;">{{ $signature->email }}</a>
                @if ($signature->website)
                    &nbsp;&bull;&nbsp;
                    <a href="{{ $signature->website }}" style="color: #d4a017; text-decoration: none;">{{ $signature->website }}</a>
                @endif
            </div>
            @if ($signature->ukraine)
                <div style="margin-top: 6px; font-size: 11px; color: #005BBB;">
                    🇺🇦 Solidaires avec l'Ukraine
                </div>
            @endif
        </td>
    </tr>
</table>
