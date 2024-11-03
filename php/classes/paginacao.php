<?php

class Paginacao{
    private $pagina;
    private $limite;
    private $totalRegistros;
    private $quantidadeLinks;



    public function __construct($paginaAtual, $limite, $totalRegistros, $quantidadeLinks = 4){
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

        $meio = floor($this->quantidadeLinks / 2);
        $intervalo_inicio = max(1, $this->pagina - $meio);
        $intervalo_fim = $intervalo_inicio + $this->quantidadeLinks - 1;

        if($intervalo_fim > $totalPaginas){
            $intervalo_fim = $totalPaginas;
            $intervalo_inicio = max(1, $intervalo_fim - $this->quantidadeLinks + 1);
        }

        return ['inicio' => $intervalo_inicio, 'fim' => $intervalo_fim];
    }
}