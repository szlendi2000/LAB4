<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAgentController extends Controller
{
    use WhichBrowser\Parser;

public function showUserAgent(Request $request)
{
    $parser = new Parser($request->header('User-Agent'));

    return response()->json([
        'browser' => $parser->browser->name,
        'version' => $parser->browser->version->value ?? 'unknown',
        'os' => $parser->os->name,
        'device' => $parser->device->type,
    ]);
}

}
