<?php

namespace Fairy;

class Boundary
{
    private $latitude = 'latitude';
    private $longitude = 'longitude';
    private static $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * @return Boundary
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * 设置纬度名
     * @param string $key
     * @return $this
     */
    public function latitudeKey(string $key)
    {
        $this->latitude = $key;

        return $this;
    }

    /**
     * 设置经度名
     * @param string $key
     * @return $this
     */
    public function longitudeKey(string $key)
    {
        $this->longitude = $key;

        return $this;
    }


    /**
     * 检查坐标范围点格式
     * @param array $points
     * @return bool
     */
    public function checkPointRange(array $points)
    {
        foreach ($points as $point) {
            if (!isset($point[$this->latitude]) || !isset($point[$this->longitude])) {
                return false;
            }
        }

        return true;
    }

    /**
     * 如果给定的点包含在边界内，则返回true
     * @param Point $point
     * @param array $points
     * @return bool
     */
    public function contains(Point $point, array $points)
    {
        if (!$this->checkPointRange($points)) {
            throw new \InvalidArgumentException('points data invalid');
        }

        $pointNum = count($points);
        $result = false;
        for ($i = 0, $j = $pointNum - 1; $i < $pointNum; $j = $i++) {
            if (
                ($points[$i][$this->longitude] > $point->y) != ($points[$j][$this->longitude] > $point->y) &&
                ($point->x < ($points[$j][$this->latitude] - $points[$i][$this->latitude]) *
                    ($point->y - $points[$i][$this->longitude]) /
                    ($points[$j][$this->longitude] - $points[$i][$this->longitude]) +
                    $points[$i][$this->latitude]
                )
            ) {
                $result = !$result;
            }
        }

        return $result;
    }
}
