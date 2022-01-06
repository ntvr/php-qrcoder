<?php

namespace com\peterbodnar\qrcoder;

use BaconQrCode\Common\ErrorCorrectionLevel as BaconQrECLevel;
use BaconQrCode\Encoder\Encoder as BaconQrEncoder;
use com\peterbodnar\mx\IMatrix;



/**
 * Data to qr-code matrix encoder
 */
class QrCoder {


	/** Level L, ~7% correction. */
	const EC_LEVEL_L = 0x01;
	/** Level M, ~15% correction. */
	const EC_LEVEL_M = 0x00;
	/** Level Q, ~25% correction. */
	const EC_LEVEL_Q = 0x03;
	/** Level H, ~30% correction. */
	const EC_LEVEL_H = 0x02;


	/** @var int */
	protected $defaultEcLevel;


	/**
	 * @param int $defaultEcLevel
	 */
	public function __construct($defaultEcLevel = self::EC_LEVEL_L) {
		$this->defaultEcLevel = $defaultEcLevel;
	}


	/**
	 * Encode data to qr-code matrix.
	 *
	 * @param string $data ~ Data to encode.
	 * @param int|null $ecLevel ~ Error correction level.
	 * @return IMatrix
	 * @throws QrCoderException
	 */
	public function encode($data, $ecLevel = NULL) {
		if (NULL === $ecLevel) {
			$ecLevel = $this->defaultEcLevel;
		}
		try {
			$qrCode = BaconQrEncoder::encode($data, BaconQrECLevel::forBits($ecLevel));
			return new MatrixAdapter($qrCode->getMatrix());
		} catch (\Exception $ex) {
			throw new QrCoderException("Error encoding data: " . $ex->getMessage(), 0, $ex);
		}
	}

}



/**
 * Class QrEncoderException
 */
class QrCoderException extends Exception { }
