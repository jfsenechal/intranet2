<?php

namespace AcMarche\QrCode\Models;

use AcMarche\QrCode\Enums\QrCodeTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Fillable([

])]
class QrCode extends Model
{

    public ?int $id = null;

    #[ORM\Column(length: 30, nullable: false)]
    public QrCodeTypeEnum $type;

    #[ORM\Column(length: 10, nullable: false)]
    public string $color = '#000000';

    #[ORM\Column(length: 10, nullable: false)]
    public string $backgroundColor = '#FFFFFF';

    #[ORM\Column(type: 'smallint', nullable: false)]
    public int $pixels = 1200;

    #[ORM\Column(length: 10, nullable: false)]
    public string $format = 'SVG';

    #[ORM\Column(length: 10, nullable: false)]
    public string $style = 'square';

    #[ORM\Column(nullable: false)]
    public int $margin = 10;

    #[ORM\Column(length: 150, nullable: true)]
    public ?string $labelText = null;

    #[ORM\Column(length: 10, nullable: true)]
    public string $labelColor = '#000000';

    #[ORM\Column(nullable: true)]
    public int $labelSize = 32;

    #[ORM\Column(length: 50, nullable: true)]
    public string $labelAlignment = 'center';

    #[ORM\Column(length: 50, nullable: false)]
    public ?string $username = null;

    #[ORM\Column(length: 150, nullable: false)]
    public ?string $name = null;

    #[ORM\Column(length: 150, nullable: true)]
    public ?string $filePath = null;

    /**
     * Simple text,Sms, phone number, email or Url
     */
    #[ORM\Column(length: 250, nullable: true)]
    public ?string $message = null;

    /**
     * Sms, phone number, email
     */
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $phoneNumber = null;
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $email = null;
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $subject = null;
    /**
     * BTC
     */
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $iban = null;
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $amount = null;
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $recipient = null;
    /**
     * Geo
     */
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $latitude = null;
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $longitude = null;
    #[ORM\Column(length: 150, nullable: true)]
    /**
     * Wifi
     */
    public ?string $ssid = null;
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $password = null;
    #[ORM\Column(length: 150, nullable: true)]
    public ?string $encryption = 'WPA';
    #[ORM\Column(nullable: true)]
    public bool $hidden = false;
}
