package Mojo::Weixin::Log;
use Mojo::Base;
use base qw(Mojo::Base Mojo::EventEmitter);
use Carp 'croak';
use Fcntl ':flock';
use Encode;
use Encode::Locale;
sub has { Mojo::Base::attr(__PACKAGE__, @_) }; 
 
has format => sub { \&_format };
has handle => sub {
 
  # STDERR
  return \*STDOUT unless my $path = shift->path;
 
  # File
  croak qq{Can't open log file "$path": $!} unless open my $file, '>>', $path;
  return $file;
};
has history => sub { [] };
has level => 'debug';
has encoding => undef;
has unicode_support => 0;
has console_output  => 0;
has max_history_size => 10;
has 'path';
 
# Supported log levels
my $LEVEL = {debug => 1, info => 2, warn => 3, error => 4, fatal => 5};
 
sub append {
  my ($self, $msg) = @_;
 
  return unless my $handle = $self->handle;
  flock $handle, LOCK_EX;
  no strict;
  if($self->unicode_support and Encode::is_utf8($msg)){
    my $data = encode($self->encoding || console_out,$msg);
    $handle->print($data) or croak "Can't write to log: $!";
    print STDOUT $data if ($self->console_output and !-t $handle and -t STDOUT);
  }
  else{
    if( $self->encoding =~/^utf-?8$/i){
      $handle->print($msg) or croak "Can't write to log: $!";
      print STDOUT $data if ($self->console_output and !-t $handle and -t STDOUT);
    }
    else{
      my $data = encode($self->encoding || console_out,decode("utf8",$msg));
      $handle->print($data) or croak "Can't write to log: $!";
      print STDOUT $data if ($self->console_output and !-t $handle and -t STDOUT);
    }
  }
  flock $handle, LOCK_UN;
}
 
sub debug { shift->_log(debug => @_) }
sub error { shift->_log(error => @_) }
sub fatal { shift->_log(fatal => @_) }
sub info  { shift->_log(info  => @_) }
 
sub is_debug { shift->_now('debug') }
sub is_error { shift->_now('error') }
sub is_info  { shift->_now('info') }
sub is_warn  { shift->_now('warn') }
 
sub new {
  my $self = shift->SUPER::new(@_);
  $self->on(message => \&_message);
  return $self;
}
 
sub warn { shift->_log(warn => @_) }
 
sub _format {
  '[' . localtime(shift) . '] [' . shift() . '] ' . join "\n", @_, '';
}
 
sub _log { shift->emit('message', shift, @_) }
 
sub _message {
  my ($self, $level) = (shift, shift);
 
  return unless $self->_now($level);
 
  my $max     = $self->max_history_size;
  my $history = $self->history;
  push @$history, my $msg = [time, $level, @_];
  shift @$history while @$history > $max;
 
  $self->append($self->format->(@$msg));
}
 
sub _now { $LEVEL->{pop()} >= $LEVEL->{$ENV{MOJO_LOG_LEVEL} || shift->level} }
 
1;