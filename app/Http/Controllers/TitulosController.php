<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TituloCreateRequest;
use App\Http\Requests\TituloUpdateRequest;
use App\Repositories\TituloRepository;
use App\Validators\TituloValidator;

use App\Empresa as Empresa;


class TitulosController extends Controller
{

    /**
     * @var TituloRepository
     */
    protected $repository;

    /**
     * @var TituloValidator
     */
    protected $validator;

    public function __construct(TituloRepository $repository, TituloValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $titulos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $titulos,
            ]);
        }

        return view('titulos.index', compact('titulos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TituloCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TituloCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $titulo = $this->repository->create($request->all());

            $response = [
                'message' => 'Titulo created.',
                'data'    => $titulo->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $titulo = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $titulo,
            ]);
        }

        return view('titulos.show', compact('titulo'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $titulo = $this->repository->find($id);

        return view('titulos.edit', compact('titulo'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  TituloUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(TituloUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $titulo = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Titulo updated.',
                'data'    => $titulo->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Titulo deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Titulo deleted.');
    }

    public function importa($estado)
    {
        Excel::load('public/sample_titulos.xlsx', function($reader) {

            $reader->each(function($sheet) {
                $empresa = Empresa::ofType($sheet->escola)->get();
                dd ($empresa);
            });


        });

    }
}
