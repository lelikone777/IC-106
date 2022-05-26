<?php 

class Config 
{

    /**
     * @var array
     */
    public const OPERATORS = [
        'mobily' => [
            'defCodes' => ['54', '56'],
            'sub_domain' => 'sakm',
            'key' => 'ksg_mobily',
            'id' => '16',
        ],
        'stc' => [
            'defCodes' => ['50', '53', '55'],
            'sub_domain' => 'saks',
            'key' => 'ksg_stc',
            'id' => '3',
        ],
        'virgin_mobile' => [
            'defCodes' => ['57'],
            'sub_domain' => 'sakv',
            'key' => 'ksg_virgin_mobile',
            'id' => '0',
        ],
        'zain' => [
            'defCodes' => ['58', '59'],
            'sub_domain' => 'sakz',
            'key' => 'ksg_zain',
            'id' => '8',
        ],
    ];

    
    /**
     * @var array
     */
    private const SERVICE_ID = [
        'main' => 17776,
        'sub_1' => 17792,
    ];


    /**
     * @var array
     */
    public const HLR_ENABLED = [
        'sub_1',
    ];


    /**
     * @return array
     */
    public static function operators(): array 
    {
        return array_keys(self::OPERATORS);
    }


    /**
     * @param string $sub_land
     * @return int
     */
    public static function serviceId(string $sub_land): int 
    {
        return self::SERVICE_ID[$sub_land];
    }
}