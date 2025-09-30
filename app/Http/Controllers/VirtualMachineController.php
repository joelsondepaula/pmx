<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Proxmox\Proxmox;

class VirtualMachineController extends Controller
{
    protected $proxmox;

    public function __construct(Proxmox $proxmox)
    {
        $this->proxmox = $proxmox;
    }

    public function index(string $nodeId)
    {
        //
    }

    public function start(string $nodeId, int $vmid)
    {
        //
    }

    public function stop(string $nodeId, int $vmid)
    {
        //
    }

    public function console(string $nodeId, int $vmid)
    {
        //
    }
}
