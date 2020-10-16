<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

trait TransformJson
{
    private function transformStringToJson(Request $request): array
    {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        return $parametersAsArray;
    }
}
