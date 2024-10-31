<?php

class Paginacao{
    private $pagina;
    private $limite;
    private $totalRegistros;
    private $quantidadeLinks;

    public function __construct($paginaAtual, $limite, $totalRegistros, $quantidadeLinks = 5){
        $this->pagina = $paginaAtual;
        $this->limite = $limite;
        $this->totalRegistros = $totalRegistros;
        $this->quantidadeLinks = $quantidadeLinks;
    }

    public function calcularInicio(){
        return ($this->pagina * $this->limite) - $this->limite;
    }

    public function calcularTotalPaginas(){
        return ceil($this->totalRegistros / $this->limite);
    }

    public function calcularIntervalo(){
        $totalPaginas = $this->calcularTotalPaginas();
        $intervalo_inicio = (($this->pagina - $this->quantidadeLinks) > 1 ? $this->pagina - $this->quantidadeLinks : 1);
        $intervalo_fim = (($this->pagina + $this->quantidadeLinks) < $totalPaginas ? $this->pagina + $this->quantidadeLinks : $totalPaginas);

        return ['inicio' => $intervalo_inicio, 'fim' => $intervalo_fim];
    }


}