drop database TLB_SA;
create database TLB_SA;
use TLB_SA;

-- Tabela: Usuario (Armazena informações sobre os usuários do sistema, como administradores e operadores.)
create table Usuario (
    id_usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(45) NOT NULL,
    email_usuario VARCHAR(45) not null,
    senha_usuario VARCHAR(255) not null,
    telefone_usuario VARCHAR(9),
    funcao_usuario ENUM("administrador", "normal") default "normal",
    foto_usuario VARCHAR(1000) not null default "../assets/img/foot_perfil.jpg",
    cep_usuario VARCHAR(9),
    estado_usuario VARCHAR(50),
    municipio_usuario VARCHAR(100),
    bairro_usuario VARCHAR(50),
    numero_usuario VARCHAR(10),
    complemento_usuario VARCHAR(50),.
    logradouro_usuario VARCHAR(50)
);

-- Tabela: estacao (Representa as paradas ou terminais ferroviários.)
CREATE TABLE estacao (
    id_estacao INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_estacao VARCHAR(100) NOT NULL,
    latitude_estacao DECIMAL(9,6) NOT NULL,
    longitude_estacao DECIMAL(9,6) NOT NULL
);

-- Tabela: rota (Define os caminhos ou linhas do sistema ferroviário.)
CREATE TABLE rota (
    id_rota INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_rota VARCHAR(100) NOT NULL,
    fk_estacao INT NOT NULL,
    FOREIGN KEY (fk_estacao) REFERENCES Estacao(id_estacao)
);

-- Tabela: segmento (Representa um trecho específico entre duas estações dentro de uma rota, modelando a malha ferroviária.)
CREATE TABLE segmento (
    id_segmento INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fk_rota INT NOT NULL,
    fk_estacao INT NOT NULL,
    comprimento_km DECIMAL(5,2),
    FOREIGN KEY (fk_rota) REFERENCES Rota(id_rota),
    FOREIGN KEY (fk_estacao) REFERENCES Estacao(id_estacao)
);

-- Tabela: trem (Armazena informações sobre as unidades de trem.)
CREATE TABLE trem (
    id_trem INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    modelo_trem VARCHAR(100) NOT NULL,
    status_operacional_trem VARCHAR(50) NOT NULL,
    localizacao_atual_trem VARCHAR(100) NOT NULL
);

-- Tabela: sensor (Define os sensores instalados nos trens ou segmentos da via.)
CREATE TABLE sensor (
    id_sensor INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo_sensor VARCHAR(50) NOT NULL,
    descricao_sensor TEXT NOT NULL,
    status_sensor ENUM('ativo', 'inativo', 'manutencao') NOT NULL,
    localizacao_sensor VARCHAR(50) NOT NULL,
    fk_trem INT NOT NULL,
    fk_segmento INT NOT NULL,
    FOREIGN KEY (fk_trem) REFERENCES Trem(id_trem),
    FOREIGN KEY (fk_segmento) REFERENCES Segmento(id_segmento)
);

-- Tabela: sensor_data (Armazena as leituras temporais de todos os sensores.)
CREATE TABLE sensor_data (
    id_data INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_sensor INT NOT NULL,
    valor_data VARCHAR(100) NOT NULL,
    data_hora TIMESTAMP NOT NULL,
    FOREIGN KEY (id_sensor) REFERENCES sensor(id_sensor)
);

-- Tabela: alerta (Registra eventos críticos ou anomalias detectadas pelo sistema de monitoramento.)
CREATE TABLE alerta (
    id_alerta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo_alerta VARCHAR(50) NOT NULL,
    mensagem_alerta TEXT NOT NULL,
    prioridade_alerta VARCHAR(20) NOT NULL,
    fk_usuario INT NOT NULL,
    data_hora TIMESTAMP NOT NULL,
    FOREIGN KEY (fk_usuario) REFERENCES Usuario(id_usuario)
);

-- Tabela: manutencao (Acompanha o histórico e agendamento das atividades de manutenção dos trens.)
CREATE TABLE manutencao (
    id_manutencao INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fk_trem INT NOT NULL,
    tipo_manutencao VARCHAR(50) NOT NULL,
    status_manutencao VARCHAR(50) NOT NULL,
    data_programada_manutencao DATE NOT NULL,
    data_realizada_manutencao DATE NOT NULL,
    FOREIGN KEY (fk_trem) REFERENCES Trem(id_trem)
);

-- Tabela: viagem (Registra os detalhes de cada percurso realizado por um trem.)
CREATE TABLE viagem (
    id_viagem INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fk_trem INT NOT NULL,
    fk_rota INT NOT NULL,
    horario_previsto_viagem TIMESTAMP NOT NULL,
    horario_real_viagem TIMESTAMP NOT NULL,
    status_viagem VARCHAR(50) NOT NULL,
    FOREIGN KEY (fk_trem) REFERENCES Trem(id_trem),
    FOREIGN KEY (fk_rota) REFERENCES Rota(id_rota)
);

-- Inserção inicial do usuário administrador padrão
insert into Usuario (nome_usuario, email_usuario, senha_usuario, funcao_usuario) values ("admin", "admin", "admin", "administrador");

-- Inserção de usuários reais de teste para simulação
INSERT INTO Usuario (nome_usuario, email_usuario, senha_usuario, telefone_usuario, funcao_usuario)
VALUES 
    ('João Silva', 'joao.silva@email.com', 'senha123', '999999999', 'normal'),
    ('Maria Oliveira', 'maria.oliveira@email.com', 'segura456', '988888888', 'normal'),
    ('Carlos Souza', 'carlos.souza@email.com', 'admin789', '977777777', 'administrador');