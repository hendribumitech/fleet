<?php

namespace App\Repositories\Base;

use App\Models\Fleet\VehicleDocument;
use App\Repositories\BaseRepository;

/**
 * Class MenusRepository.
 *
 * @version July 27, 2021, 2:20 am UTC
 */
class HomeRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * Return searchable fields.
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }    

    public function getNotifications(){
        return [
            'document' => $this->documentNotifications(),
        ];
    }
    // get all document vechicle almost expired
    private function documentNotifications(){
        $result = [];        
        $documentVehicle = VehicleDocument::with(['vehicle', 'document'])->almostExpired()->get()->groupBy('document_id');
        if($documentVehicle){
            $tmp = ['title' => '', 'datas' => []];
            foreach($documentVehicle as $docs){
                $tmp['title'] = $docs->first()->document->name;
                foreach($docs as $doc){
                    $tmp['datas'][] = ['url' => route('fleet.vehicles.documents.index', [$doc->vehicle_id]) , 'text' => $doc->name ?? '-' .' kendaraan '. $doc->vehicle->name ?? '-'.' aktif sampai dengan <strong>'.$doc->expired_at.'</strong>'];
                    $result[] = $tmp;
                }
            }
        }
        return $result;
    }
}
