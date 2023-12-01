<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Materia;
use App\Models\Periodo;
use App\Models\Semestre;
class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($semestre_id)
    {
        //
        $semestre = Semestre::find($semestre_id);
        $materias = Materia::where('semestre_id', $semestre_id)->get();
        $horarios=Horario::orderBy("hora_inicio","asc")->get(); 
        $periodos=Periodo::all();
        return view('SemestreHorarios.index',compact('semestre','materias','horarios','periodos'));
    }

    public function guardarRegistro(Request $request)
    {
        // Obtiene los datos enviados por la solicitud AJAX
        $materiaId = $request->input('materia_id');
        $horarioId = $request->input('horario_id');
        $laboratorioId = $request->input('laboratorio_id');
        $dia = $request->input('dia');
        $semestreId= $request->input('semestre_id');
        $semestreid=Materia::find($materiaId)->semestre_id;

        $docenteId = Materia::find($materiaId)->docente_id;
        if($docenteId){
            $registroDocExistente = Periodo::whereHas('materia', function($query) use ($docenteId,$semestreId) {
                $query->where('docente_id', $docenteId)->where('semestre_id', '!=', $semestreId);
            })
            ->where('horario_id', $horarioId)
            ->where('dia', $dia)
            ->first();
            if ($registroDocExistente) {
                return response()->json(['error' => 'Ya existe un registro para el docente de esta materia en otra materia.']);
            }
        }
        // Crea un nuevo registro en la tabla periodo
        if ($laboratorioId){
            if($semestreid){
                $registroSemExistente=Periodo::whereHas('materia', function($query) use ($semestreid) {
                    $query->where('semestre_id', $semestreid);
                    
                })->where('horario_id', $horarioId)
                ->where('dia', $dia)
                ->first();
                if ($registroSemExistente) {
                    return response()->json(['error' => 'Ya existe un registro para el semestre de esta materia en el mismo horario y dia.']);
                }
            }
            $registroExistente = Periodo::where('materia_id', $materiaId)
            ->where('horario_id', $horarioId)
            ->where('dia', $dia)
            ->where('laboratorio_id', '!=', $laboratorioId)
            ->first();

            if ($registroExistente) {
                return response()->json(['error' => 'Ya existe un registro para esta materia en otro laboratorio.']);
            }
            Periodo::where('horario_id', $horarioId)
               ->where('dia', $dia)->where('laboratorio_id', $laboratorioId)->orwhere('horario_id', $horarioId)->where('dia', $dia)->wherenull('laboratorio_id')
               ->delete();
        }
        else{
            Periodo::where('horario_id', $horarioId)
               ->where('dia', $dia)->whereHas('materia', function($query) use ($semestreId) {
                $query->where('semestre_id', $semestreId);
            })->delete();
        }
        
        $registro = new Periodo();
        $registro->materia_id = $materiaId;
        $registro->horario_id = $horarioId;
        $registro->dia = $dia;
        $registro->laboratorio_id = $laboratorioId;
        
        // Guarda el registro en la base de datos
        $registro->save();
        

        // Puedes devolver una respuesta JSON como confirmación de éxito si lo deseas
        return response()->json(['message' => 'Registro guardado con éxito']);
    }
    public function eliminarRegistro(Request $request){
        $horarioId = $request->input('horario_id');
        $laboratorioId = $request->input('laboratorio_id');
        $semestreId= $request->input('semestre_id');
        $dia = $request->input('dia');
        if ($laboratorioId){
            Periodo::where('horario_id', $horarioId)
               ->where('dia', $dia)->where('laboratorio_id', $laboratorioId)->orwhere('horario_id', $horarioId)->where('dia', $dia)->wherenull('laboratorio_id')
               ->delete();
        }
        else{
            Periodo::where('horario_id', $horarioId)
               ->where('dia', $dia)->whereHas('materia', function($query) use ($semestreId) {
                $query->where('semestre_id', $semestreId);
            })->delete();
        }
        return response()->json(['message' => 'Registro eliminado con éxito']);
    }
}
