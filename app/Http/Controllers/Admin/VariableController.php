<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVariableRequest;
use App\Http\Requests\UpdateVariableRequest;
use App\Models\Variable;
use Illuminate\Support\Facades\DB;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class VariableController extends Controller
{
    public function create()
    {
        $variable = $this->prepareVariable();

        $this->authorize('viewOrCreateOrUpdate', $variable);

        return view('admin.variables.create', compact('variable'));
    }

    public function store(CreateVariableRequest $request)
    {
        $variable = $this->prepareVariable();
        $this->authorize('viewOrCreateOrUpdate', $variable);

        $data = $request->validated();
        $variable = Variable::create($data);

        return redirect()
            ->route(auth()->user()->role . '.tests.show', $variable->test_id)
            ->withSuccess('Переменная создана');
    }

    public function edit(Variable $variable)
    {
        $this->authorize('viewOrCreateOrUpdate', $variable);

        return view('admin.variables.edit', compact('variable'));
    }

    public function update(UpdateVariableRequest $request, Variable $variable)
    {
        $this->authorize('viewOrCreateOrUpdate', $variable);

        $data = $request->validated();
        $variable->fill($data);
        DB::transaction(function () use ($variable) {
            if ($variable->isDirty('name')) {
                $results = $variable->results;
                foreach ($results as $result) {
                    $expression = new ExpressionLanguage();
                    $variables = $variable->test->variables->pluck('name')
                        ->toArray();
                    $nodes = $expression->parse($result->condition, $variables)
                        ->getNodes();
                    $this->f2($nodes, $variable->getOriginal('name'), $variable->name);
                    $result->condition = $nodes->dump();
                    $result->save();
                }
            }
            $variable->save();
        });

        return redirect()->route(auth()->user()->role . '.tests.variables.show', $variable)
            ->withSuccess('Переменная обновлена');
    }

    public function show(Variable $variable)
    {
        $this->authorize('view', $variable);

        return view('admin.variables.show', compact('variable'));

    }

    public function destroy(Variable $variable)
    {
        $this->authorize('deleteOrRestore', $variable);

        if ($variable->results()->exists()) {
            return redirect()->back()
                ->withErrors('Переменную нельзя удалить, эта переменная используется в результатах');
        }

        $variable->delete();

        return redirect()->route(auth()->user()->role . '.tests.show', $variable->test->id)
            ->withSuccess('Переменная удалена');
    }

    public function restore($id)
    {
        $variable = Variable::onlyTrashed()->find($id);
        $this->authorize('deleteOrRestore', $variable);
        $variable->restore();

        return back()->withSuccess('Переменная восстановлена');
    }

    protected function prepareVariable(): Variable
    {
        return new Variable([
            'test_id' => (int) request()
                ->get('test_id'),
        ]);
    }

    private function f2($root, string $oldVariableName, string $newVariableName): void
    {
        if (isset($root->nodes) && isset($root->nodes['left'])) {
            $this->f2($root->nodes['left'], $oldVariableName, $newVariableName);
        }
        if (isset($root->nodes) && isset($root->nodes['right'])) {
            $this->f2($root->nodes['right'], $oldVariableName, $newVariableName);
        }
        if (isset($root->attributes['name']) && $root->attributes['name'] === $oldVariableName) {
            $root->attributes['name'] = $newVariableName;
        }

    }
}
