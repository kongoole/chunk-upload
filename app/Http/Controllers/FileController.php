<?php

namespace App\Http\Controllers;
use App\Utils\FileAssembler;
use App\Utils\FileUtils;
use Illuminate\Http\Request;

/**
 * Class FileController
 *
 * @package \App\Http\Controllers
 */
class FileController
{
	public function view()
	{
		return view('view');
	}

	public function upload(Request $request)
	{
	    if ($request->hasFile('foo_file')) {
	        $path = $request->file('foo_file')->store('foo');
	        return response()->json([
	            'status' => 200,
                'data' => [
                    'path' => $path
                ]
            ]);
        }
        return response()->json(['status' => 400]);
	}

    /**
     * packing a file
     *
     * @param Request $request
     * @param FileAssembler $fileAssembler
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function packing(Request $request, FileAssembler $fileAssembler)
    {
        $path = FileUtils::pathPrefix() . 'apk' . DIRECTORY_SEPARATOR . md5(microtime() . openssl_random_pseudo_bytes(100));
        $fileAssembler->assemble($request['files'], $path);
        $gameId = $request['game_id'];
        $channelId = $request['channel_id'];
        $packName = $request['pack_name'];
        return response()->json();
    }
}