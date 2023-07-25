namespace App\Tables;

use App\Models\Clientes;
use Okipa\LaravelTable\Table;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;

class tableClientes extends AbstractTableConfiguration
{
    protected function table(): Table
    {
        return Table::make()->model(User::class);
    }
}