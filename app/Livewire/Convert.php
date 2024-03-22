<?php

namespace App\Livewire;

use App\Services\ParseWebConfigService;
use \Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Convert extends Component
{
    use WithFileUploads;

    public $configFile;
    public string $destinationFile = 'redirect.conf';
    public bool $showConvertControls = true;
    public bool $showDownloadControls = false;

    public function save()
    {
        $this->validate([
            'configFile' => 'file|mimetypes:application/xml,text/xml',
        ]);

        $uploadedFile = $this->configFile->storeAs('config_files', 'web.config');
        $filePath = Storage::path($uploadedFile);

        if (file_exists($filePath) && ParseWebConfigService::isValidXml($filePath)) {
            $this->convert(Storage::path($uploadedFile));
        }
    }

    public function download(): BinaryFileResponse
    {
        return response()->download(storage_path('app/output/' . $this->destinationFile));
    }

    public function clear(): void
    {
        $this->showConvertControls = true;
        $this->showDownloadControls = false;
    }

    protected function convert(string $filename): void
    {
        $parser = new ParseWebConfigService();

        $success = $parser->run($filename, $this->destinationFile)
            ->parse();

        if ($success) {
            $this->showConvertControls = false;
            $this->showDownloadControls = true;
        }
    }

    public function render()
    {
        return view('livewire.convert');
    }
}
